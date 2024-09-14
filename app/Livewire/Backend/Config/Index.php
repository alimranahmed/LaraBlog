<?php

namespace App\Livewire\Backend\Config;

use App\Models\Config;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Component;

class Index extends Component
{
    public array $editingConfig = [];

    public array $rules = [
        'editingConfig.name' => '',
        'editingConfig.value' => 'required',
    ];

    public function render(): View
    {
        $configs = Config::query()
            ->whereNotIn('name', [Config::FAVICON, Config::USER_PHOTO])
            ->get();

        return view('livewire.backend.config.index', compact('configs'));
    }

    public function startEditing(Config $config): void
    {
        $this->editingConfig = $config->toArray();
    }

    public function update(): void
    {
        $data = $this->validate();
        Config::query()->findOrFail($this->editingConfig['id'])
            ->update(Arr::get($data, 'editingConfig'));

        $this->reset(['editingConfig']);
    }
}
