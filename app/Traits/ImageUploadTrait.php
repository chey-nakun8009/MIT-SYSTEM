<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait ImageUploadTrait
{
    /**
     * Save an already-cropped image uploaded from Cropper.js.
     *
     * @param UploadedFile $file
     * @param string $directory (e.g., 'upload/projects')
     * @return string Relative path of the saved image
     */
    public function uploadAndCropImage(UploadedFile $file, string $directory): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path($directory);

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Move the client-side cropped file directly without forced center-cropping resizing
        $file->move($destinationPath, $filename);

        return $directory . '/' . $filename;
    }

    public function deleteImage(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            @unlink(public_path($path));
        }
    }

    public function uploadBase64Image(string $base64Data, string $directory): string
    {
        list($type, $base64Data) = explode(';', $base64Data);
        list(, $base64Data) = explode(',', $base64Data);

        $imageDecoded = base64_decode($base64Data);
        $filename = time() . '_' . uniqid() . '.png';
        $destinationPath = public_path($directory);

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $filePath = $destinationPath . '/' . $filename;
        file_put_contents($filePath, $imageDecoded);

        return $directory . '/' . $filename;
    }
}
