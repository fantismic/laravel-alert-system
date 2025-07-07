<?php

namespace Fantismic\AlertSystem\Http\Livewire;

use Fantismic\AlertSystem\Models\AlertRecipient;
use Fantismic\AlertSystem\Models\AlertType;
use Fantismic\AlertSystem\Models\AlertChannel;
use Livewire\Component;
use Livewire\WithPagination;

class ManageRecipients extends Component
{
    use WithPagination;

    public $type_id, $channel_id, $address, $editingId = null;
    public $types, $channels;

    protected $rules = [
        'type_id' => 'required|exists:alert_types,id',
        'channel_id' => 'required|exists:alert_channels,id',
        'address' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->types = AlertType::all();
        $this->channels = AlertChannel::all();
    }

    public function save()
    {
        $this->validate();

        AlertRecipient::updateOrCreate(
            ['id' => $this->editingId],
            [
                'alert_type_id' => $this->type_id,
                'alert_channel_id' => $this->channel_id,
                'address' => $this->address,
            ]
        );

        $this->reset(['type_id', 'channel_id', 'address', 'editingId']);
    }

    public function edit($id)
    {
        $r = AlertRecipient::findOrFail($id);
        $this->editingId = $r->id;
        $this->type_id = $r->alert_type_id;
        $this->channel_id = $r->alert_channel_id;
        $this->address = $r->address;
    }

    public function delete($id)
    {
        AlertRecipient::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('alert-system::livewire.alert-system.manage-recipients', [
            'recipients' => AlertRecipient::with('type', 'channel')->paginate(10)
        ]);
    }
}
