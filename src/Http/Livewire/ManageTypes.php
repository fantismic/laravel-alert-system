<?php

namespace Fantismic\AlertSystem\Http\Livewire;

use Fantismic\AlertSystem\Models\AlertType;
use Livewire\Component;
use Livewire\WithPagination;

class ManageTypes extends Component
{
    use WithPagination;

    public $name, $editingId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        AlertType::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->name]
        );

        $this->reset(['name', 'editingId']);
    }

    public function edit($id)
    {
        $type = AlertType::findOrFail($id);
        $this->editingId = $type->id;
        $this->name = $type->name;
    }

    public function delete($id)
    {
        AlertType::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('alert-system::livewire.alert-system.manage-types', [
            'types' => AlertType::paginate(10)
        ]);
    }
}
