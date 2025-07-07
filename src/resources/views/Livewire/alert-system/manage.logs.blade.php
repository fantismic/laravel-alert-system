<div>
    <h1 class="text-2xl font-bold mb-4">Recent Alerts</h1>

    <input type="text" wire:model.debounce.500ms="search" placeholder="Search type..." class="mb-4 p-2 border rounded">

    <table class="w-full table-auto text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Type</th>
                <th>Channel</th>
                <th>Address</th>
                <th>Status</th>
                <th>Sent At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr class="border-t">
                    <td class="p-2">{{ $log->type }}</td>
                    <td>{{ $log->channel }}</td>
                    <td>{{ $log->address }}</td>
                    <td>
                        @if ($log->status === 'success')
                            <span class="text-green-600 font-semibold">✔</span>
                        @else
                            <span class="text-red-600 font-semibold">✘</span>
                        @endif
                    </td>
                    <td>{{ $log->sent_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">No alerts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
