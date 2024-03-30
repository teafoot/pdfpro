<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;
// use Smalot\PdfParser\Parser;
use App\Models\PdfUpload;
use Illuminate\Support\Facades\Log;

class ExtractMainPdfText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pdfUpload;

    public function __construct($pdfUpload)
    {
        $this->pdfUpload = $pdfUpload;
    }

    public function handle()
    {
        // Use the Storage facade to get the absolute path
        $pdfFilePath = Storage::disk('public')->path($this->pdfUpload->file_path);
        
        if (Storage::disk('public')->exists($this->pdfUpload->file_path)) {
            // $parser = new Parser();
            // $pdf = $parser->parseFile($pdfFilePath);
            // $text = $pdf->getText(); // too big error
            $command = "pdftotext -enc UTF-8 " . escapeshellarg($pdfFilePath) . " -";
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                $text = implode("\n", $output);
                $text = cleanText($text);

                $this->pdfUpload->extracted_text = $text;
                $this->pdfUpload->save();
            } else {
                Log::error("pdftotext command failed with status {$returnVar}: " . implode("\n", $output));
            }
        } else {
            Log::error("PDF file does not exist: {$pdfFilePath}");
        }
    }
}
