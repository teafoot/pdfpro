<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PdfChapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'pdf_upload_id',
        'chapter_number',
        'chapter_title',
        'chapter_path',
        'chapter_text',
    ];

    public function pdfUpload(): BelongsTo
    {
        return $this->belongsTo(PdfUpload::class);
    }
}
