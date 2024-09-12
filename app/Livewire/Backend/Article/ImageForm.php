<?php
declare(strict_types=1);

namespace App\Livewire\Backend\Article;

use App\Models\Image;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ImageForm extends Component
{
    use WithFileUploads;

    #[Validate(['image' => 'image|max:2048'])] // 2MB
    public null|TemporaryUploadedFile $image = null;

    public array $files = [];

    public function render(): View
    {
        return view('livewire.backend.article.image-form');
    }

    public function updatedImage(): void
    {
        $this->validate();
        $this->save();
    }

    public function save(): void
    {
        $path = $this->image->store(path: 'images');

        /** @var Image $image */
        $image = Image::query()->create([
            'uuid' => Str::uuid(),
            'src' => $path,
            'src_type' => 'internal',
        ]);

        $this->files[] = [
            'name' => $this->image->getClientOriginalName(),
            'url' => route('file', [$image->uuid]),
            'size' => $this->formatFileSize($this->image->getSize()),
        ];
    }

    private function formatFileSize(int $bytes, int $precision = 2): string
    {
        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];

        if ($bytes == 0) {
            return '0 Bytes';
        }

        $index = floor(log($bytes, 1024)); // Find the appropriate unit
        $fileSize = $bytes / pow(1024, $index); // Convert size to the appropriate unit

        return round($fileSize, $precision) . ' ' . $units[$index];
    }
}
