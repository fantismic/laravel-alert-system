<?php

namespace Fantismic\AlertSystem\Http\Livewire;

use Fantismic\AlertSystem\Models\AlertChannel;
use Livewire\Component;
use Livewire\WithPagination;

class ManageChannels extends Component
{
    use WithPagination;

    public $name, $editingId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        AlertChannel::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->name]
        );

        $this->reset(['name', 'editingId']);
    }

    public function edit($id)
    {
        $channel = AlertChannel::findOrFail($id);
        $this->editingId = $channel->id;
        $this->name = $channel->name;
    }

    public function delete($id)
    {
        AlertChannel::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('alert-system::livewire.alert-system.manage-channels', [
            'channels' => AlertChannel::paginate(10)
        ])->layout(config('alert-system.layout'));;
    }
}
