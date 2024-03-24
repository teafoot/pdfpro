<?php

namespace App\Filament\Resources\PdfUploadResource\Pages;

use App\Filament\Resources\PdfUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePdfUpload extends CreateRecord
{
    protected static string $resource = PdfUploadResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return self::getResource()::getUrl('index');
    }
}
