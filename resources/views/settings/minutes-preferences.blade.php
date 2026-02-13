<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minutes format') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-10">
                    <div>
                        <h3 class="text-base font-semibold">{{ __('Instructions') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('These instructions will be used by your OpenClaw publisher when generating minutes.') }}
                        </p>

                        <form method="POST" action="{{ route('settings.minutes-preferences.update') }}" class="mt-4 space-y-3">
                            @csrf
                            @method('PUT')

                            <textarea
                                name="instructions"
                                rows="8"
                                class="w-full rounded-md border-gray-300"
                                placeholder="{{ __('Example: Keep it short. Use bullets. Always include Time and Attendees. All actions must have owner + deadline.') }}"
                            >{{ old('instructions', $preference->instructions) }}</textarea>

                            @error('instructions')
                                <div class="text-sm text-red-600">{{ $message }}</div>
                            @enderror

                            <div>
                                <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                                    {{ __('Save instructions') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold">{{ __('Template') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Upload a template document (PDF / DOCX / TXT / MD). We will extract text and use it as guidance.') }}
                        </p>

                        @if ($template)
                            <div class="mt-4 rounded-lg border border-gray-200 p-4">
                                <div class="flex items-center justify-between gap-6">
                                    <div>
                                        <div class="font-medium">{{ $template->file_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $template->mime_type }}</div>
                                    </div>

                                    <form method="POST" action="{{ route('settings.minutes-preferences.media.destroy', $template) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm text-red-600 underline">{{ __('Remove') }}</button>
                                    </form>
                                </div>

                                @if ($template->getCustomProperty('extracted_text_error'))
                                    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-900">
                                        {{ __('Could not extract text from this file. Install pdftotext (poppler-utils) or configure PDFTOTEXT_BINARY.') }}
                                    </div>
                                @endif

                                @if ($preference->template_extracted_text)
                                    <details class="mt-4">
                                        <summary class="cursor-pointer text-sm text-gray-700 underline">
                                            {{ __('Show extracted text') }}
                                        </summary>
                                        <pre class="mt-3 whitespace-pre-wrap rounded-lg border border-gray-200 bg-gray-50 p-4 text-xs leading-5 text-gray-900">{{ $preference->template_extracted_text }}</pre>
                                    </details>
                                @endif
                            </div>
                        @endif

                        <form method="POST" action="{{ route('settings.minutes-preferences.template') }}" enctype="multipart/form-data" class="mt-4 flex items-center gap-3">
                            @csrf
                            <input type="file" name="template" class="block w-full text-sm" required />
                            <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                                {{ $template ? __('Replace') : __('Upload') }}
                            </button>
                        </form>
                        @error('template')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <h3 class="text-base font-semibold">{{ __('Examples') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Upload example minutes. OpenClaw can read these via the API and mimic the style.') }}
                        </p>

                        <div class="mt-4 divide-y divide-gray-100">
                            @forelse ($examples as $example)
                                <div class="py-3 flex items-center justify-between gap-6">
                                    <div>
                                        <div class="font-medium">{{ $example->file_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $example->mime_type }}</div>
                                    </div>

                                    <form method="POST" action="{{ route('settings.minutes-preferences.media.destroy', $example) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm text-red-600 underline">{{ __('Remove') }}</button>
                                    </form>
                                </div>
                            @empty
                                <div class="py-6 text-sm text-gray-600">
                                    {{ __('No examples uploaded yet.') }}
                                </div>
                            @endforelse
                        </div>

                        <form method="POST" action="{{ route('settings.minutes-preferences.examples') }}" enctype="multipart/form-data" class="mt-4 flex items-center gap-3">
                            @csrf
                            <input type="file" name="example" class="block w-full text-sm" required />
                            <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                                {{ __('Upload') }}
                            </button>
                        </form>
                        @error('example')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                        <div class="font-semibold">{{ __('Server requirements') }}</div>
                        <ul class="mt-2 list-disc pl-5 space-y-1">
                            <li>{{ __('PDF extraction requires: pdftotext (poppler-utils).') }}</li>
                            <li>{{ __('DOCX extraction requires: pandoc.') }}</li>
                            <li>{{ __('Set PDFTOTEXT_BINARY and PANDOC_BINARY if the binaries are not on PATH.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
