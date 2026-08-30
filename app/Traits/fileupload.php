<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait FileUpload
{
    /**
     * Uploads a file to leave_appl folder in public storage.
     * Creates folder if not exists and replaces existing file with same name.
     *
     * @param UploadedFile $file
     * @param string|null $fileName Optional: rename file, default original name
     * @return string Path of uploaded file relative to storage/app/public
     */
    public function uploadLeaveFile(UploadedFile $file, ?string $fileName = null): string
    {
        $folder = 'leave_appl';
        $disk   = Storage::disk('public');

        // ✅ Allowed MIME → extension mapping
        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'application/pdf' => 'pdf',
        ];

        $mimeType = $file->getMimeType();

        if (!array_key_exists($mimeType, $allowedMimeTypes)) {
            throw new \InvalidArgumentException('Invalid file type uploaded.');
        }

        // ✅ Always trust MIME, not original extension
        $extension = $allowedMimeTypes[$mimeType];

        // ✅ Auto-generate filename if not provided
        if (!$fileName) {
            $fileName = 'leave_' . now()->format('YmdHis') . '_' . Str::random(6);
        }

        // ✅ Force correct extension
        $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '.' . $extension;

        // ✅ Create folder if not exists
        if (!$disk->exists($folder)) {
            $disk->makeDirectory($folder);
        }

        $filePath = $folder . '/' . $fileName;

        // ✅ Replace file if exists
        if ($disk->exists($filePath)) {
            $disk->delete($filePath);
        }

        // ✅ Store file
        $disk->putFileAs($folder, $file, $fileName);

        return $filePath;
    }
}
