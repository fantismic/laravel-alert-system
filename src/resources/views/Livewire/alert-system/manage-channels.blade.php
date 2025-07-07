<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Manage Alert Channels</h2>

    <form wire:submit.prevent="save" class="space-y-4 mb-6">
        <div>
            <label class="block text-sm">Name</label>
            <input type="text" wire:model="name" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded">
            {{ $editingId ? 'Update' : 'Add' }} Channel
        </button>
    </form>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-2">Name</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($channels as $channel)
                <tr class="border-t">
                    <td class="p-2">{{ $channel->name }}</td>
                    <td class="p-2 space-x-2">
                        <button wire:click="edit({{ $channel->id }})" class="text-blue-500">Edit</button>
                        <button wire:click="delete({{ $channel->id }})" class="text-red-500">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $channels->links() }}
    </div>
</div>
