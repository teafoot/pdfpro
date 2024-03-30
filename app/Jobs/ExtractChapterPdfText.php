<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;
use App\Models\PdfChapter;
use Illuminate\Support\Facades\Log;

class ExtractChapterPdfText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pdfChapter;

    public function __construct($pdfChapter)
    {
        $this->pdfChapter = $pdfChapter;
    }

    public function handle()
    {
        // Use the Storage facade to get the absolute path
        $pdfChapterPath = Storage::disk('public')->path($this->pdfChapter->chapter_path);

        if (Storage::disk('public')->exists($this->pdfChapter->chapter_path)) {
            // $parser = new Parser();
            // $pdf = $parser->parseFile($this->pdfChapter->chapter_path);
            // $text = $pdf->getText(); // too big error
    
            $command = "pdftotext -enc UTF-8 " . escapeshellarg($pdfChapterPath) . " -";
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                $text = implode("\n", $output);
                $text = cleanText($text);

                $this->pdfChapter->chapter_text = $text;
                $this->pdfChapter->save();
            } else {
                Log::error("pdftotext command failed with status {$returnVar}: " . implode("\n", $output));
            }
        } else {
            Log::error("PDF file does not exist: {$pdfChapterPath}");
        }
    }
}
