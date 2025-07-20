<section class="text-gray-900 dark:text-gray-100 p-2">
    <div class="w-full max-w-5xl lg:max-w-full mx-auto mt-2">

        <!-- Título arriba -->
        <h1 class="text-3xl font-bold mb-6 flex items-center gap-2">
            <svg class="h-8 w-8 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 32 32" stroke="currentColor">
                <circle cx="16" cy="16" r="14" stroke-width="2.5"/>
                <path d="M16 10v7" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="16" cy="22" r="1.5" fill="currentColor"/>
            </svg>
            Recent Alerts
        </h1>

        <!-- Filtros -->
        <div class="flex flex-wrap gap-4 mb-6 bg-white/80 dark:bg-gray-900/80 rounded-xl shadow p-4 ring-1 ring-gray-200 dark:ring-gray-700">
            <input type="text" wire:model.live="search" placeholder="Buscar..."
                class="p-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex-1 min-w-[170px] focus:outline-none focus:ring-2 focus:ring-gray-400" />

            <select wire:model="status" class="p-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-w-[150px] focus:outline-none focus:ring-2 focus:ring-gray-400">
                <option value="">Todos los estados</option>
                <option value="success">Success</option>
                <option value="failure">Failure</option>
            </select>

            <select wire:model="type" class="p-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-w-[150px] focus:outline-none focus:ring-2 focus:ring-gray-400">
                <option value="">Todos los tipos</option>
                @foreach(Fantismic\AlertSystem\Models\AlertLog::select('type')->distinct()->pluck('type') as $alertType)
                    <option value="{{ $alertType }}">{{ $alertType }}</option>
                @endforeach
            </select>

            <select wire:model="channel" class="p-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-w-[150px] focus:outline-none focus:ring-2 focus:ring-gray-400">
                <option value="">Todos los canales</option>
                @foreach(\Fantismic\AlertSystem\Models\AlertLog::select('channel')->distinct()->pluck('channel') as $channel)
                    <option value="{{ $channel }}">{{ $channel }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tabla Alerts -->
        <div class="rounded-2xl shadow bg-white/95 dark:bg-gray-900/95 overflow-x-auto ring-1 ring-gray-200 dark:ring-gray-700">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-800 text-left">
                    <tr>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Tipo</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Canal</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Destino</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Bot</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Estado</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Enviado</th>
                        <th class="p-3 font-semibold text-gray-700 dark:text-gray-200 text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="p-3">{{ $log->type }}</td>
                            <td class="p-3">{{ $log->channel }}</td>
                            <td class="p-3">{{ $log->address }}</td>
                            <td class="p-3">{{ $log->bot ?? '-' }}</td>
                            <td class="p-3 text-sm">
                                <span class="inline-flex items-center gap-1 font-semibold
                                    {{ $log->status === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    @if ($log->status === 'success')
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <td class="p-3">{{ $log->sent_at->format('Y-m-d H:i') }}</td>
                            <td class="p-3 text-center">
                                <button wire:click="showDetails({{ $log->id }})"
                                    class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 shadow transition"
                                    title="Ver detalles">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/>
                                        <circle cx="12" cy="12" r="3.5" fill="currentColor"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-4 text-gray-500 dark:text-gray-400">No hay alertas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>

    @if ($selectedLog)
        <!-- Modal Detalles -->
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl max-w-2xl w-full text-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 32 32" stroke="currentColor">
                            <circle cx="16" cy="16" r="14" stroke-width="2.5"/>
                            <path d="M16 10v7" stroke-width="2.5" stroke-linecap="round"/>
                            <circle cx="16" cy="22" r="1.5" fill="currentColor"/>
                        </svg>
                        Detalle de alerta
                    </h2>
                    <button wire:click="$set('selectedLog', null)"
                        class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                        title="Cerrar">
                        <svg class="h-5 w-5 text-gray-500 dark:text-gray-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="space-y-2 mb-2">
                    <p><strong>Tipo:</strong> {{ $selectedLog->type }}</p>
                    <p><strong>Canal:</strong> {{ $selectedLog->channel }}</p>
                    <p><strong>Destino:</strong> {{ $selectedLog->address }}</p>
                    <p><strong>Estado:</strong>
                        @if ($selectedLog->status === 'success')
                            <span class="font-semibold text-green-600 dark:text-green-400">Success</span>
                        @else
                            <span class="font-semibold text-red-600 dark:text-red-400">Failure</span>
                        @endif
                    </p>
                    <p><strong>Asunto:</strong> {{ $selectedLog->subject }}</p>
                    <p><strong>Mensaje:</strong> {{ $selectedLog->message }}</p>
                    <p><strong>Error:</strong> {{ $selectedLog->error_message ?? 'N/A' }}</p>
                    <div>
                        <p class="font-semibold mb-1">Detalles:</p>
                        <ul class="ml-6 text-sm list-disc">
                            @foreach($selectedLog->details ?? [] as $k => $v)
                                <li><strong>{{ $k }}:</strong> {{ $v }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
