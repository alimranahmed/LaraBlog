<?php

namespace App\Http\Livewire\Backend\Config;

use App\Models\Config;
use Illuminate\Support\Arr;
use Livewire\Component;

class Index extends Component
{
    public $editingConfig;

    public $rules = [
        'editingConfig.name' => '',
        'editingConfig.value' => 'required',
    ];

    public function render()
    {
        $configs = Config::all();

        return view('livewire.backend.config.index', compact('configs'));
    }

    public function startEditing(Config $config)
    {
        $this->editingConfig = $config;
    }

    public function update()
    {
        $data = $this->validate();
        $this->editingConfig->update(Arr::get($data, 'editingConfig'));
        $this->reset('editingConfig');
    }
}
