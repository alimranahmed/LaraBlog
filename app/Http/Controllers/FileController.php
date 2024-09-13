<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    public function path($uuid): BinaryFileResponse
    {
        /** @var ?Image $image */
        $image = Image::query()->where('uuid', $uuid)->firstOrFail();

        return response()->download(Storage::path($image->src));
    }
}
