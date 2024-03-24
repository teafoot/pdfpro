<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PdfUpload;
use App\Services\PdfService;


class ProcessPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pdfUpload;

    public function __construct(PdfUpload $pdfUpload)
    {
        $this->pdfUpload = $pdfUpload;
    }

    public function handle()
    {
        $this->pdfUpload->update(['status' => 'processing']);
        $success = app(PdfService::class)->process($this->pdfUpload);

        $status = $success ? 'completed' : 'failed';
        $this->pdfUpload->update(['status' => $status]);
    }
}