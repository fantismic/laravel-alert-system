<?php

namespace Fantismic\AlertSystem\Http\Livewire;


use Livewire\Component;
use Livewire\WithPagination;
use Fantismic\AlertSystem\Models\AlertLog;

class ManageLogs extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $status = '';
    public $type = '';
    public $channel = '';
    public $selectedLog = null;

    public function showDetails($logId)
    {
        $this->selectedLog = AlertLog::findOrFail($logId);
    }

    public function render()
    {
        $query = AlertLog::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('type', 'like', "%{$this->search}%")
                ->orWhere('channel', 'like', "%{$this->search}%")
                ->orWhere('address', 'like', "%{$this->search}%")
                ->orWhere('status', 'like', "%{$this->search}%")
                ->orWhere('subject', 'like', "%{$this->search}%")
                ->orWhere('message', 'like', "%{$this->search}%");
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->channel) {
            $query->where('channel', $this->channel);
        }

        $logs = $query->latest()->paginate($this->perPage);

        return view('alert-system::livewire.alert-system.manage-logs', compact('logs'))
            ->layout(config('alert-system.layout'));
    }
}
