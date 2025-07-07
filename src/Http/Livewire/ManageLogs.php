<?php

namespace Fantismic\AlertSystem\Http\Livewire;

use App\Models\AlertLog;
use Livewire\Component;
use Livewire\WithPagination;

class ManageLogs extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $logs = AlertLog::latest()
            ->when($this->search, fn($q) => $q->where('type', 'like', "%{$this->search}%"))
            ->paginate($this->perPage);

        return view('livewire.alert-system.manage-logs', compact('logs'))
            ->layout(config('alert-system.layout'));
    }
}
