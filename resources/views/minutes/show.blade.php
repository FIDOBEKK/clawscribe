<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $minute->title }}
            </h2>

            <a href="{{ route('minutes.index') }}" class="text-sm font-medium text-gray-900 underline">
                {{ __('Back to list') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <div class="text-sm text-gray-600">
                        <div>
                            <span class="font-medium text-gray-900">{{ __('When:') }}</span>
                            {{ $minute->occurred_at?->format('Y-m-d H:i') }}
                        </div>

                        @if ($minute->drive_referat_path)
                            <div class="mt-1">
                                <span class="font-medium text-gray-900">{{ __('Drive (minutes):') }}</span>
                                {{ $minute->drive_referat_path }}
                            </div>
                        @endif

                        @if ($minute->drive_audio_path)
                            <div class="mt-1">
                                <span class="font-medium text-gray-900">{{ __('Drive (audio):') }}</span>
                                {{ $minute->drive_audio_path }}
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-base font-semibold">{{ __('Minutes') }}</h3>

                        <div class="mt-3 rounded-lg border border-gray-200 bg-white p-5">
                            <div class="prose max-w-none">
                                {!! $minute->rendered_markdown !!}
                            </div>
                        </div>

                        <details class="mt-4">
                            <summary class="cursor-pointer text-sm text-gray-700 underline">
                                {{ __('Show raw Markdown') }}
                            </summary>
                            <pre class="mt-3 whitespace-pre-wrap rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm leading-6 text-gray-900">{{ $minute->markdown }}</pre>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
