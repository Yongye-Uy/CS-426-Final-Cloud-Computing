<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = config('filesystems.default', 'local');
    }

    /**
     * Set the disk to use
     */
    public function disk(string $disk): self
    {
        $this->disk = $disk;
        return $this;
    }

    /**
     * Upload a file
     */
    public function upload(UploadedFile $file, string $path = 'uploads'): string
    {
        $filename = $this->generateFilename($file->getClientOriginalExtension());
        $fullPath = $path . '/' . $filename;

        Storage::disk($this->disk)->put($fullPath, file_get_contents($file));

        return $this->getUrl($fullPath);
    }

    /**
     * Upload file with custom filename
     */
    public function uploadAs(UploadedFile $file, string $path, string $filename): string
    {
        $fullPath = $path . '/' . $filename;

        Storage::disk($this->disk)->put($fullPath, file_get_contents($file));

        return $this->getUrl($fullPath);
    }

    /**
     * Upload from URL
     */
    public function uploadFromUrl(string $url, string $path = 'uploads'): ?string
    {
        try {
            $contents = file_get_contents($url);
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = $this->generateFilename($extension);
            $fullPath = $path . '/' . $filename;

            Storage::disk($this->disk)->put($fullPath, $contents);

            return $this->getUrl($fullPath);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Upload base64 encoded image
     */
    public function uploadBase64(string $base64, string $path = 'uploads'): ?string
    {
        try {
            // Extract extension and data from base64
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
                $extension = $matches[1];
                $data = substr($base64, strpos($base64, ',') + 1);
            } else {
                $extension = 'png';
                $data = $base64;
            }

            $contents = base64_decode($data);
            $filename = $this->generateFilename($extension);
            $fullPath = $path . '/' . $filename;

            Storage::disk($this->disk)->put($fullPath, $contents);

            return $this->getUrl($fullPath);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Delete a file
     */
    public function delete(string $path): bool
    {
        return Storage::disk($this->disk)->delete($path);
    }

    /**
     * Get file URL
     */
    public function getUrl(string $path): string
    {
        return Storage::disk($this->disk)->url($path);
    }

    /**
     * Check if file exists
     */
    public function exists(string $path): bool
    {
        return Storage::disk($this->disk)->exists($path);
    }

    /**
     * Get file size
     */
    public function size(string $path): int
    {
        return Storage::disk($this->disk)->size($path);
    }

    /**
     * Generate unique filename
     */
    protected function generateFilename(string $extension): string
    {
        return Str::uuid() . '.' . strtolower($extension);
    }
}
