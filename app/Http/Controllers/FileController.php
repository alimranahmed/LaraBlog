<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    public function path(string $imageUuidOrConfigName): BinaryFileResponse
    {
        /** @var ?Image $src */
        $src = Image::query()
            ->where('uuid', $imageUuidOrConfigName)
            ->value('src');

        if ($src === null) {
            $src = Config::query()
                ->where('name', $imageUuidOrConfigName)
                ->value('value');
        }

        if ($src == null) {
            abort(404);
        }

        return response()->download(Storage::path($src));
    }
}
