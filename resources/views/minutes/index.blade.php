<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minutes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            {{ __('Sorted by date (newest first).') }}
                        </p>
                        <a href="{{ route('settings.api-tokens.index') }}" class="text-sm font-medium text-gray-900 underline">
                            {{ __('API tokens') }}
                        </a>
                    </div>

                    <div class="mt-6 divide-y divide-gray-100">
                        @forelse ($minutes as $minute)
                            <div class="py-4">
                                <div class="flex items-start justify-between gap-6">
                                    <div>
                                        <div class="text-sm text-gray-500">
                                            {{ $minute->occurred_at?->format('Y-m-d H:i') }}
                                        </div>
                                        <div class="mt-1 font-semibold text-gray-900">
                                            {{ $minute->title }}
                                        </div>
                                        @if ($minute->drive_referat_path)
                                            <div class="mt-2 text-xs text-gray-500">
                                                {{ __('Drive:') }} {{ $minute->drive_referat_path }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right text-xs text-gray-500">
                                        {{ __('ID:') }} {{ $minute->id }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-sm text-gray-600">
                                {{ __('No minutes yet. Once OpenClaw publishes your first minutes, they will appear here.') }}
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $minutes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
