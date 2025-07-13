<div class="w-full max-w-5xl lg:max-w-full mx-auto mt-2">
    <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr] gap-8 items-start">

        <!-- Tabla desktop + cards mobile -->
        <div class="order-2 md:order-1 rounded-3xl shadow-2xl bg-white/90 dark:bg-gray-900/80 backdrop-blur-md ring-1 ring-blue-300/20 transition-all duration-300 p-6 w-full">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-blue-700 dark:text-blue-300">
                <svg class="h-7 w-7 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 32 32" stroke="currentColor">
                    <rect x="6" y="10" width="20" height="12" rx="6" stroke-width="2.2"/>
                    <path d="M8 14h16M8 18h10" stroke-width="2"/>
                </svg>
                Manage Recipients
            </h2>
            <!-- Tabla desktop -->
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-[600px] w-full rounded-xl bg-white/90 shadow-md dark:bg-gray-800/80 overflow-hidden text-sm">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-200 font-semibold">Type</th>
                            <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-200 font-semibold">Channel</th>
                            <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-200 font-semibold">Address</th>
                            <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-200 font-semibold">Bot</th>
                            <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-200 font-semibold">Active</th>
                            <th class="py-3 px-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recipients as $recipient)
                            <tr class="hover:bg-blue-50 dark:hover:bg-blue-900/30 transition">
                                <td class="py-2 px-4">{{ $recipient->type->name }}</td>
                                <td class="py-2 px-4">{{ $recipient->channel->name }}</td>
                                <td class="py-2 px-4">{{ $recipient->address }}</td>
                                <td class="py-2 px-4">{{ $recipient->bot ?? '—' }}</td>
                                <td class="py-2 px-4 text-center">
                                    @if ($recipient->is_active)
                                        <span class="inline-flex items-center gap-1 font-bold text-green-500">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 font-bold text-red-500">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 flex gap-2 justify-end">
                                    <button wire:click="edit({{ $recipient->id }})"
                                        class="p-2 rounded hover:bg-blue-100 dark:hover:bg-blue-900/30 group transition"
                                        title="Edit">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15.232 5.232l3.536 3.536M9 13.5V17h3.5L20.232 9.768a2 2 0 000-2.828l-2.172-2.172a2 2 0 00-2.828 0L9 13.5z" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $recipient->id }})"
                                        class="p-2 rounded hover:bg-red-100 dark:hover:bg-red-900/30 group transition"
                                        onclick="return confirm('Delete recipient?')" title="Delete">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 px-4 text-center text-gray-400 dark:text-gray-500">No recipients</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pt-4">
                    {{ $recipients->links('pagination::tailwind') }}
                </div>
            </div>
            <!-- Cards mobile -->
            <div class="md:hidden flex flex-col gap-4 mt-2">
                @forelse ($recipients as $recipient)
                    <div class="rounded-xl bg-gray-100/90 dark:bg-gray-800/90 shadow px-4 py-3 flex flex-col gap-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $recipient->address }}</span>
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $recipient->id }})"
                                    class="p-2 rounded hover:bg-blue-200 dark:hover:bg-blue-900/50" title="Edit">
                                    <svg class="h-5 w-5 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15.232 5.232l3.536 3.536M9 13.5V17h3.5L20.232 9.768a2 2 0 000-2.828l-2.172-2.172a2 2 0 00-2.828 0L9 13.5z" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                <button wire:click="delete({{ $recipient->id }})"
                                    class="p-2 rounded hover:bg-red-200 dark:hover:bg-red-900/50" onclick="return confirm('Delete recipient?')" title="Delete">
                                    <svg class="h-5 w-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 text-gray-800 dark:text-gray-200 text-xs">
                            <span><strong>Type:</strong> {{ $recipient->type->name }}</span>
                            <span><strong>Channel:</strong> {{ $recipient->channel->name }}</span>
                            <span><strong>Bot:</strong> {{ $recipient->bot ?? '—' }}</span>
                            <span><strong>Active:</strong>
                                @if ($recipient->is_active)
                                    <span class="text-green-500 font-bold">✓</span>
                                @else
                                    <span class="text-red-500 font-bold">✗</span>
                                @endif
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-400 text-center">No recipients</div>
                @endforelse
                <div class="pt-4">
                    {{ $recipients->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="order-1 md:order-2 rounded-3xl shadow-2xl bg-white/90 dark:bg-gray-900/80 backdrop-blur-md ring-1 ring-blue-300/20 transition-all duration-300 p-8 md:p-10 w-full">
            <div class="flex items-center gap-3 mb-4">
                <svg class="h-10 w-10 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 32 32" stroke="currentColor">
                    <rect x="6" y="10" width="20" height="12" rx="6" stroke-width="2.2"/>
                    <path d="M8 14h16M8 18h10" stroke-width="2"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                    {{ $editingId ? 'Edit Recipient' : 'New Recipient' }}
                </h2>
            </div>
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 font-medium">Type</label>
                    <select wire:model="type_id"
                        class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/90 dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 transition">
                        <option value="">-- Select Type --</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 font-medium">Channel</label>
                    <select wire:model="channel_id"
                        class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/90 dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 transition">
                        <option value="">-- Select Channel --</option>
                        @foreach ($channels as $channel)
                            <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 font-medium">Address</label>
                    <input type="text" wire:model="address"
                        class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/90 dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 transition"
                        placeholder="user@example.com or @telegramChatId">
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 font-medium">Bot Token Key (optional)</label>
                    <input type="text" wire:model="bot"
                        class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/90 dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 transition"
                        placeholder="Config key (e.g. 'default'), NOT the real token">
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" wire:model="is_active" id="is_active"
                        class="rounded text-blue-600 dark:bg-gray-900 dark:border-gray-700 focus:ring-blue-500 transition">
                    <label for="is_active" class="text-gray-700 dark:text-gray-200 select-none cursor-pointer">Active</label>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="py-2 px-6 rounded-xl font-bold bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 dark:from-blue-500 dark:via-blue-400 dark:to-blue-300 text-white hover:scale-[1.03] hover:shadow-lg transition-all duration-150 shadow-md tracking-tight text-lg flex items-center gap-2">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ $editingId ? 'Update' : 'Add' }} Recipient
                    </button>
                    @if($editingId)
                        <button type="button" wire:click="cancelEdit"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 font-medium transition">Cancel</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
