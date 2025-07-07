<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Manage Recipients</h2>

    <form wire:submit.prevent="save" class="space-y-4 mb-6">
        <div>
            <label class="block text-sm">Type</label>
            <select wire:model="type_id" class="w-full border rounded p-2">
                <option value="">-- Select Type --</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm">Channel</label>
            <select wire:model="channel_id" class="w-full border rounded p-2">
                <option value="">-- Select Channel --</option>
                @foreach ($channels as $channel)
                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm">Address</label>
            <input type="text" wire:model="address" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            {{ $editingId ? 'Update' : 'Add' }} Recipient
        </button>
    </form>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-2">Type</th>
                <th class="p-2">Channel</th>
                <th class="p-2">Address</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recipients as $recipient)
                <tr class="border-t">
                    <td class="p-2">{{ $recipient->type->name }}</td>
                    <td class="p-2">{{ $recipient->channel->name }}</td>
                    <td class="p-2">{{ $recipient->address }}</td>
                    <td class="p-2 space-x-2">
                        <button wire:click="edit({{ $recipient->id }})" class="text-blue-500">Edit</button>
                        <button wire:click="delete({{ $recipient->id }})" class="text-red-500">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $recipients->links() }}
    </div>
</div>
