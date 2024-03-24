<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\PdfUpload;
use mikehaertl\pdftk\Pdf;

class ConvertPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pdfUpload;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\PdfUpload  $pdfUpload
     * @return void
     */
    public function __construct($pdfUpload)
    {
        $this->pdfUpload = $pdfUpload;
    }

    /**
     * Execute the job to convert the PDF using Ghostscript.
     *
     * @return void
     */
    public function handle()
    {
        // Define the full path to the uploaded PDF
        $inputPdfPath = storage_path('app/public/' . $this->pdfUpload->file_path);

        // Define the path for the bookmarks file
        $bookmarksPath = storage_path('app/public/pdfs/bookmarks.txt');

        // Extract bookmarks to a file using mikehaertl\pdftk\Pdf
        $pdf = new Pdf($inputPdfPath);
        $data = $pdf->getData(); // Retrieve the bookmarks data as a string
        if (!$data) {
            $error = $pdf->getError();
            Log::error("Bookmark extraction failed: $error");
            $this->pdfUpload->update(['status' => 'failed']);
            return;
        }
        // Save the bookmarks data to a file
        if (!file_put_contents($bookmarksPath, $data)) {
            Log::error("Failed to save bookmark data to file");
            $this->pdfUpload->update(['status' => 'failed']);
            return;
        }

        // Define the path for the converted PDF
        $convertedFilename = 'converted_' . $this->pdfUpload->original_filename;
        $convertedFilePath = 'pdfs/' . $convertedFilename;
        $outputPdfPath = storage_path('app/public/' . $convertedFilePath);

        // Convert the PDF using Ghostscript
        $command = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -sOutputFile=" . escapeshellarg($outputPdfPath) . " " . escapeshellarg($inputPdfPath);
        exec($command, $output, $returnVar);
        if ($returnVar !== 0) {
            Log::error("PDF conversion failed: " . implode("\n", $output));
            $this->pdfUpload->update(['status' => 'failed']);
            return;
        }
        // Apply bookmarks to the new PDF using mikehaertl\pdftk\Pdf
        $finalOutputPath = storage_path('app/public/pdfs/final_' . $convertedFilename);
        $pdf = new Pdf($outputPdfPath);
        $result = $pdf->updateInfo($bookmarksPath)->saveAs($finalOutputPath);
        if (!$result) {
            $error = $pdf->getError();
            Log::error("Bookmark update failed: $error");
            $this->pdfUpload->update(['status' => 'failed']);
            return;
        }

        // Update the file path to the final PDF with bookmarks
        $this->pdfUpload->update([
            'file_path' => 'pdfs/final_' . $convertedFilename,
            'status' => 'converted',
        ]);

        // Optionally, delete the intermediate files
        // Storage::delete($convertedFilePath);
        // Storage::delete($bookmarksPath);
    }
}
