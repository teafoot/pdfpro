<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PdfUpload;
use App\Services\SchemaOrg;
use Inertia\Inertia;

use Illuminate\Http\Request;
use App\Jobs\ProcessPdfJob;
use App\Jobs\ConvertPdf;

class PdfController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // file_put_contents(storage_path('logs/log.log'), json_encode($user));

        $uploads = $user->pdfUploads()->latest()->get();
        return response()->json($uploads);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'uploadedFile' => 'required|file|mimes:pdf|max:1004800', // 1000MB max size
        ]);

        $file = $request->file('uploadedFile');
        $originalFilename = $file->getClientOriginalName();
        $filePath = $file->store('pdfs', 'public'); // Store in the 'pdfs' directory in the 'public' disk
    //     $path = $file->store('pdfs', 's3'); // Replace 's3' with your cloud disk name (s3, digitalocean)

        $pdfUpload = PdfUpload::create([
            'user_id' => auth()->id(),
            'original_filename' => $originalFilename,
            'file_path' => $filePath,
            'status' => 'pending', // Initial status
        ]);

        ConvertPdf::dispatch($pdfUpload);

        return response()->json($pdfUpload, 201);
    }

    public function split(Request $request)
    {
        $request->validate([
            'pdf_upload_id' => 'required|integer',
        ]);
    
        $pdfUploadId = $request->input('pdf_upload_id');
        $pdfUpload = PdfUpload::find($pdfUploadId);
    
        if (!$pdfUpload) {
            return response()->json(['message' => 'PDF upload not found.'], 404);
        }
        if ($pdfUpload->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized access to PDF upload.'], 403);
        }
    
        // Check if the status is not already 'processing' to avoid duplicate jobs
        // if ($pdfUpload->status == 'converted') {
            ProcessPdfJob::dispatch($pdfUpload);
            return response()->json(['message' => 'PDF splitting process started.'], 202);
        // } else {
        //     return response()->json(['message' => 'PDF is not converted.'], 200);
        // }
    }

    // public function process($pdfUpload)
    // {
    //     try {
    //         // Use smalot/pdfparser to extract bookmarks (if they are stored as text)
    //         $parser = new Parser();
    //         $pdf = $parser->parseFile($pdfUpload->file_path);
    //         $bookmarks = $this->extractBookmarks($pdf); // Implement this method based on your PDF structure

    //         // Use FPDI to split the PDF
    //         $pdf = new Fpdi();
    //         $pageCount = $pdf->setSourceFile($pdfUpload->file_path);

    //         foreach ($bookmarks as $bookmark) {
    //             // Create a new PDF document for each chapter based on the bookmarks
    //             $this->createChapterPdf($pdf, $bookmark, $pageCount); // Implement this method
    //         }

    //         // Update the status
    //         $pdfUpload->update(['status' => 'completed']);
    //     } catch (\Exception $e) {
    //         // Handle any exceptions and update the status to 'failed'
    //         $pdfUpload->update(['status' => 'failed']);
    //         Log::error($e->getMessage());
    //     }
    // }

    // private function extractBookmarks($pdf)
    // {
    //     // Implement logic to extract bookmarks from the text of the PDF
    // }

    // private function createChapterPdf($pdf, $bookmark, $pageCount)
    // {
    //     // Implement logic to create a new PDF file for each chapter
    // }
}
