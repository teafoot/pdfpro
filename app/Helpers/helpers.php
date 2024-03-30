<?php

if (!function_exists('generateUniqueFilename')) {
    /**
     * Generate a unique filename for a given original filename.
     *
     * @param  string $originalFilename
     * @return string
     */
    function generateUniqueFilename($originalFilename)
    {
        $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
        $filenameWithoutExtension = pathinfo($originalFilename, PATHINFO_FILENAME);

        $now = new DateTime();
        $timestamp = $now->format('Y_m_d_His') . '_' . substr((string) $now->format('u'), 0, 3); // include milliseconds

        $uniqueFilename = $filenameWithoutExtension . '_' . $timestamp . '.' . $extension;

        return $uniqueFilename;
    }
}

if (!function_exists('cleanText')) {
    function cleanText($text) {
        // Remove non-UTF8 characters
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        // Remove control characters
        $text = preg_replace('/[\x00-\x1F\x7F]/', '', $text);
        // Remove multiple spaces
        $text = preg_replace('/\s+/', ' ', $text);
        return $text;
    }
}
