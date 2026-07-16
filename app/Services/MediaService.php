<?php

namespace App\Services;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function upload($file, string $folder = 'uploads'): string
    {
        $filename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
        return $file->storeAs($folder, $filename, 'public');
    }

    public function uploadMultiple(array $files, string $folder = 'uploads'): array
    {
        return array_map(fn($file) => $this->upload($file, $folder), $files);
    }

    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    public function replace(string $oldPath, $newFile, string $folder = 'uploads'): string
    {
        $this->delete($oldPath);
        return $this->upload($newFile, $folder);
    }
}
