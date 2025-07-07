<section class="text-gray-900 dark:text-gray-100 p-6">
<div>
    <h1 class="text-3xl font-bold mb-4">Recent Alerts</h1>

    <div class="flex flex-wrap gap-4 mb-4">
        <input type="text" wire:model.live="search" placeholder="Search type..."
            class="p-2 border rounded bg-white dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100">

        <select
            class="appearance-none pr-8 bg-no-repeat bg-right dark:bg-gray-800 dark:text-white bg-[url('data:image/svg+xml;utf8,<svg fill=\'%23999\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>')] ..."
        >
            <option value="">All Statuses</option>
            <option value="success">Success</option>
            <option value="failure">Failure</option>
        </select>

        <select
            class="appearance-none pr-8 bg-no-repeat bg-right dark:bg-gray-800 dark:text-white bg-[url('data:image/svg+xml;utf8,<svg fill=\'%23999\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>')] ..."
        >
            <option value="">All Types</option>
            @foreach(Fantismic\AlertSystem\Models\AlertLog::select('type')->distinct()->pluck('type') as $alertType)
                <option value="{{ $alertType }}">{{ $alertType }}</option>
            @endforeach
        </select>

        <select
            class="appearance-none pr-8 bg-no-repeat bg-right dark:bg-gray-800 dark:text-white bg-[url('data:image/svg+xml;utf8,<svg fill=\'%23999\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>')] ..."
        >
            <option value="">All Channels</option>
            @foreach(\Fantismic\AlertSystem\Models\AlertLog::select('channel')->distinct()->pluck('channel') as $channel)
                <option value="{{ $channel }}">{{ $channel }}</option>
            @endforeach
        </select>
    </div>

<table class="w-full table-auto text-sm border-collapse border dark:border-gray-700">
    <thead class="bg-gray-100 dark:bg-gray-800 text-left">
        <tr>
            <th class="p-3 font-semibold">Type</th>
            <th class="p-3 font-semibold">Channel</th>
            <th class="p-3 font-semibold">Address</th>
            <th class="p-3 font-semibold">Status</th>
            <th class="p-3 font-semibold">Sent At</th>
            <th class="p-3 font-semibold">#</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($logs as $log)
            <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                <td class="p-3">{{ $log->type }}</td>
                <td class="p-3">{{ $log->channel }}</td>
                <td class="p-3">{{ $log->address }}</td>
                <td class="p-3">
                    @if ($log->status === 'success')
                        <span class="text-green-400 font-semibold">✔</span>
                    @else
                        <span class="text-red-500 font-semibold">✘</span>
                    @endif
                </td>
                <td class="p-3">{{ $log->sent_at->format('Y-m-d H:i') }}</td>
                <td class="p-3">
                    <button wire:click="showDetails({{ $log->id }})" class="text-blue-500 underline">Details</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center p-4 text-gray-500 dark:text-gray-400">No alerts found.</td>
            </tr>
        @endforelse
    </tbody>
</table>


    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>

@if ($selectedLog)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xl max-w-2xl w-full text-gray-800 dark:text-gray-100">
            <h2 class="text-lg font-bold mb-2">Alert Details</h2>

            <p><strong>Type:</strong> {{ $selectedLog->type }}</p>
            <p><strong>Channel:</strong> {{ $selectedLog->channel }}</p>
            <p><strong>Address:</strong> {{ $selectedLog->address }}</p>
            <p><strong>Status:</strong> {{ $selectedLog->status }}</p>
            <p><strong>Subject:</strong> {{ $selectedLog->subject }}</p>
            <p><strong>Message:</strong> {{ $selectedLog->message }}</p>
            <p><strong>Error:</strong> {{ $selectedLog->error_message ?? 'N/A' }}</p>
            <p><strong>Details:</strong></p>
            <ul class="ml-4 text-sm list-disc">
                @foreach($selectedLog->details ?? [] as $k => $v)
                    <li><strong>{{ $k }}:</strong> {{ $v }}</li>
                @endforeach
            </ul>

            <button wire:click="$set('selectedLog', null)"
                class="mt-4 px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">Close</button>
        </div>
    </div>
@endif
</section>
