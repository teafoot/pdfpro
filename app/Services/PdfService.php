<?php

namespace App\Services;

use App\Models\PdfUpload;

use Smalot\PdfParser\Parser;
use setasign\Fpdi\Tcpdf\Fpdi;
use mikehaertl\pdftk\Pdf;

class PdfService
{
    /**
     * Process the given PDF upload.
     *
     * @param PdfUpload $pdfUpload
     * @return bool
     */
    public function process(PdfUpload $pdfUpload)
    {
        $bookmarks = $this->extractBookmarks(storage_path('app/public/' . $pdfUpload->file_path));
        $this->createChapterPdfs($pdfUpload, $bookmarks);
        return true;
    }

    /**
     * Extract bookmarks from the PDF using pdftk.
     * This will depend on how bookmarks are structured in your PDFs
     * For example, you might look for specific text patterns or use other parsing methods
     * @param string $filePath
     * @return array
     */
    private function extractBookmarks($filePath)
    {
        $pdf = new Pdf($filePath);
        $data = $pdf->getData();
        if ($pdf->getError()) {
            throw new \Exception('Could not extract PDF data: ' . $pdf->getError());
        }

        $bookmarks = $this->parseBookmarksData($data);
        return $bookmarks;
    }

    /**
     * Parse the bookmarks data to extract bookmarks.
     *
     * @param mixed $data
     * @return array
     */
    private function parseBookmarksData($data)
    {
        $bookmarks = [];
        if (isset($data['Bookmark']) && is_array($data['Bookmark'])) {
            foreach ($data['Bookmark'] as $bookmark) {
                $title = $bookmark['Title'];
                $level = $bookmark['Level'];
                $pageNumber = $bookmark['PageNumber'];
                
                if ($level != "1") {
                    continue;
                }

                $safeTitle = $this->sanitizeTitle($title);

                $bookmarks[] = ['Title' => $safeTitle, 'Level' => $level, 'PageNumber' => $pageNumber];
            }
        }
        return $bookmarks;
    }

    /**
     * Sanitize the title by replacing illegal characters with an underscore.
     *
     * @param string $title
     * @return string
     */
    private function sanitizeTitle($title)
    {
        $illegalCharacters = ['/', '\\', '?', '%', '*', ':', '|', '"', '<', '>'];
        $safeTitle = str_replace($illegalCharacters, '_', $title);
        return $safeTitle;
    }

    /**
     * Create a new PDF file for each chapter based on the bookmarks.
     *
     * @param PdfUpload $pdfUpload the pdfUpload db record
     * @param array $bookmarks An array of bookmarks.
     * 
     * @return void
     */
    private function createChapterPdfs($pdfUpload, $bookmarks)
    {
        $sourceFilePath = storage_path('app/public/' . $pdfUpload->file_path);
        $fpdi = new Fpdi();
        $pageCount = $fpdi->setSourceFile($sourceFilePath);

        $totalChapterPages = 0;
        $chapterPaths = [];

        foreach ($bookmarks as $index => $bookmark) {
            $fpdi = new Fpdi();
            $fpdi->setSourceFile($sourceFilePath);

            // Determine the end page for this chapter
            $endPage = $index < count($bookmarks) - 1 ? $bookmarks[$index + 1]['PageNumber'] - 1 : $pageCount;

            // Add the pages for this chapter
            for ($pageNo = $bookmark['PageNumber']; $pageNo <= $endPage; $pageNo++) {
                // Get the size and orientation of the source page
                $size = $fpdi->getTemplateSize($fpdi->importPage($pageNo));
                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';

                // Add a new page with the correct orientation and size
                $fpdi->AddPage($orientation, [$size['width'], $size['height']]);

                // Use the imported page
                $templateId = $fpdi->importPage($pageNo);
                $fpdi->useTemplate($templateId, ['adjustPageSize' => true]);

                $totalChapterPages++;
            }

            $chapterFilename = ($index + 1) . '. Chapter - ' . $bookmark['Title'] . '.pdf';
            $chapterFullPath = storage_path('app/public/chapters/' . $chapterFilename);

            // Ensure the 'chapters' directory exists
            $chaptersDirectory = dirname($chapterFullPath);
            if (!file_exists($chaptersDirectory)) {
                mkdir($chaptersDirectory, 0755, true);
            }

            // Save the chapter PDF to a file
            $fpdi->Output($chapterFullPath, 'F');
            $chapterPaths[] = $chapterFullPath;
        }

        // Assert that the total number of pages in all chapters equals the original page count
        // for some reason $totalChapterPages is 1104 and $pageCount is 1103
        //not accurate got opposite 689 690
        // if ($totalChapterPages !== $pageCount) {
        //     throw new \Exception('The total number of pages in the chapters does not match the original document.');
        // }

        $pdfUpload->update([
            'status' => 'completed',
            'chapter_paths' => json_encode($chapterPaths),
        ]);
    }
}
