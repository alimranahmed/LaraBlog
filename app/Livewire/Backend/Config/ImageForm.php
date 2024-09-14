<?php

namespace App\Livewire\Backend\Config;

use App\Models\Config;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ImageForm extends Component
{
    use WithFileUploads;

    #[Validate('nullable|file|mimes:ico,png,svg||max:200')] // 200MB
    public ?TemporaryUploadedFile $favicon = null;

    #[Validate('nullable|image|max:1024')] // 1MB
    public ?TemporaryUploadedFile $user_photo = null;

    public array $existingPaths;

    public function mount(): void
    {
        $this->existingPaths = [
            Config::FAVICON => Config::getPath(Config::FAVICON),
            Config::USER_PHOTO => Config::getPath(Config::USER_PHOTO),
        ];
    }

    /**
     * @throws \Exception
     */
    public function saveConfigFile(string $configName): void
    {
        if ($this->{$configName} === null) {
            return;
        }

        $this->validate();

        if (! in_array($configName, [Config::FAVICON, Config::USER_PHOTO], true)) {
            throw new Exception("Invalid config name: \"$configName\" for upload file.");
        }

        $this->deleteConfigMedia($configName);

        $path = $this->{$configName}->storeAs(
            path: 'configs',
            name: "$configName.".$this->{$configName}->getClientOriginalExtension()
        );

        $this->insertConfig($configName, $path);

        $this->redirect(route('backend.config.index'));
    }

    public function resetConfigFile(string $configName): void
    {
        $this->deleteConfigMedia($configName);
        Config::query()->where('name', $configName)->delete();
        $this->redirect(route('backend.config.index'));
    }

    private function deleteConfigMedia(string $configName): void
    {
        /** @var Config $config */
        $config = Config::query()->where('name', $configName)->first();
        if ($config) {
            Storage::delete($config->value);
        }
    }

    private function insertConfig($configName, string $path): void
    {
        Config::query()->updateOrCreate([
            'name' => $configName,
        ], [
            'value' => $path,
            'is_media' => true,
        ]);
    }

    public function render(): View
    {
        return view('livewire.backend.config.image-form');
    }
}
