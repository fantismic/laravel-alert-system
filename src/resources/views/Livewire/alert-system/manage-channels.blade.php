<div class="p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Manage Alert Channels</h2>

    <form wire:submit.prevent="save" class="space-y-4 mb-6">
        <div>
            <label class="block text-sm text-gray-800 dark:text-gray-300">Name</label>
            <input
                type="text"
                wire:model="name"
                class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                placeholder="Channel name..."
            >
        </div>

        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded transition">
            {{ $editingId ? 'Update' : 'Add' }} Channel
        </button>
    </form>

    <table class="w-full table-auto border-collapse text-gray-900 dark:text-gray-100">
        <thead>
            <tr class="bg-gray-200 dark:bg-gray-700 text-left">
                <th class="p-2 text-gray-800 dark:text-gray-100">Name</th>
                <th class="p-2 text-gray-800 dark:text-gray-100">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($channels as $channel)
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="p-2">{{ $channel->name }}</td>
                    <td class="p-2 space-x-2">
                        <button wire:click="edit({{ $channel->id }})" class="text-blue-500 hover:underline">Edit</button>
                        <button wire:click="delete({{ $channel->id }})" class="text-red-500 hover:underline">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $channels->links() }}
    </div>
</div>
