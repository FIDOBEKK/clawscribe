<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('API tokens') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <div>
                        <h3 class="text-base font-semibold">{{ __('Create token') }}</h3>
                        <form method="POST" action="{{ route('settings.api-tokens.store') }}" class="mt-3 flex gap-3">
                            @csrf
                            <input name="name" type="text" class="w-full rounded-md border-gray-300" placeholder="{{ __('Token name') }}" required />
                            <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                                {{ __('Create') }}
                            </button>
                        </form>
                        @error('name')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($plainTextToken)
                        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                            <div class="text-sm font-semibold text-amber-900">{{ __('Copy this token now — it will only be shown once.') }}</div>
                            <div class="mt-2 break-all rounded bg-white p-3 font-mono text-xs text-gray-900">{{ $plainTextToken }}</div>
                        </div>
                    @endif

                    <div>
                        <h3 class="text-base font-semibold">{{ __('Existing tokens') }}</h3>
                        <div class="mt-3 divide-y divide-gray-100">
                            @forelse ($tokens as $token)
                                <div class="py-3 flex items-center justify-between gap-3">
                                    <div>
                                        <div class="font-medium">{{ $token->name }}</div>
                                        <div class="text-xs text-gray-500">{{ __('Created:') }} {{ $token->created_at?->format('Y-m-d H:i') }}</div>
                                    </div>
                                    <form method="POST" action="{{ route('settings.api-tokens.destroy', $token->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm text-red-600 underline">
                                            {{ __('Revoke') }}
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="py-6 text-sm text-gray-600">
                                    {{ __('No tokens yet.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
