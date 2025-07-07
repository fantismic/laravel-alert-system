<div class="p-6">
    <h2 class="text-3xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Manage Recipients</h2>

    <form wire:submit.prevent="save" class="space-y-4 mb-6">
        <div>
            <label class="block text-sm text-gray-800 dark:text-gray-300">Type</label>
            <select wire:model="type_id"
                class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                <option value="">-- Select Type --</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-800 dark:text-gray-300">Channel</label>
            <select wire:model="channel_id"
                class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                <option value="">-- Select Channel --</option>
                @foreach ($channels as $channel)
                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-800 dark:text-gray-300">Address</label>
            <input type="text" wire:model="address"
                class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100"
                placeholder="user@example.com or @telegramChatId">
        </div>

        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
            {{ $editingId ? 'Update' : 'Add' }} Recipient
        </button>
    </form>

    <table class="w-full table-auto border-collapse text-gray-900 dark:text-gray-100">
        <thead>
            <tr class="bg-gray-200 dark:bg-gray-700 text-left">
                <th class="p-2 text-gray-800 dark:text-gray-100">Type</th>
                <th class="p-2 text-gray-800 dark:text-gray-100">Channel</th>
                <th class="p-2 text-gray-800 dark:text-gray-100">Address</th>
                <th class="p-2 text-gray-800 dark:text-gray-100">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recipients as $recipient)
                <tr
                    class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="p-2">{{ $recipient->type->name }}</td>
                    <td class="p-2">{{ $recipient->channel->name }}</td>
                    <td class="p-2">{{ $recipient->address }}</td>
                    <td class="p-2 space-x-2">
                        <button wire:click="edit({{ $recipient->id }})" class="text-blue-500 hover:underline">Edit</button>
                        <button wire:click="delete({{ $recipient->id }})" class="text-red-500 hover:underline">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $recipients->links() }}
    </div>
</div>
