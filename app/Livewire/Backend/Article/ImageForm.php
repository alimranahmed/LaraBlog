<?php

declare(strict_types=1);

namespace App\Livewire\Backend\Article;

use App\Models\Image;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ImageForm extends Component
{
    use WithFileUploads;

    #[Validate('image|max:2048')] // 2MB
    public ?TemporaryUploadedFile $image_file = null;

    public array $files = [];

    public function render(): View
    {
        return view('livewire.backend.article.image-form');
    }

    /**
     * @throws ValidationException
     */
    public function updatedImageFile(): void
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->image_file = null;
            throw $e;
        }
        $this->save();
    }

    public function save(): void
    {
        $path = $this->image_file->storeAs(
            path: 'images',
            name: now()->format('Y-m-d-H-i-s').time().'.'.$this->image_file->getClientOriginalExtension()
        );

        /** @var Image $image */
        $image = Image::query()->create([
            'uuid' => Str::uuid(),
            'src' => $path,
            'src_type' => 'internal',
        ]);

        $this->files[] = [
            'uuid' => (string) $image->uuid,
            'name' => $this->image_file->getClientOriginalName(),
            'url' => route('file', [$image->uuid]),
            'size' => $this->formatFileSize($this->image_file->getSize()),
        ];
    }

    public function delete(string $uuid): void
    {
        /** @var Image $image */
        $image = Image::query()->where('uuid', $uuid)->firstOrFail();

        Storage::delete($image->src);

        $image->delete();

        $this->files = collect($this->files)
            ->where('uuid', '!=', $uuid)
            ->toArray();
    }

    private function formatFileSize(int $bytes, int $precision = 2): string
    {
        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];

        if ($bytes == 0) {
            return '0 Bytes';
        }

        $index = floor(log($bytes, 1024)); // Find the appropriate unit
        $fileSize = $bytes / pow(1024, $index); // Convert size to the appropriate unit

        return round($fileSize, $precision).' '.$units[$index];
    }
}
