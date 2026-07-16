<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Guarda una sola imagen y retorna su ruta.
     */
    public function uploadImage(UploadedFile $file, string $folder = 'productos'): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Guardamos en el disco 'public' (storage/app/public)
        $path = $file->storeAs($folder, $filename, 'public');

        return $path;
    }

    /**
     * Elimina una imagen (Te servirá después para el método update/destroy)
     */
    public function deleteImage(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}