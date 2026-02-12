<x-guest-layout>
    <div class="mx-auto max-w-3xl px-6 py-16">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900">
            {{ __('ClawScribe') }}
        </h1>

        <p class="mt-4 text-lg text-gray-600">
            {{ __('A simple home for your meeting minutes — published by OpenClaw, browsed by humans.') }}
        </p>

        <div class="mt-8 flex gap-3">
            @auth
                <a href="{{ route('minutes.index') }}" class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
                    {{ __('Open minutes') }}
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
                    {{ __('Get started') }}
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-gray-200 hover:bg-gray-50">
                    {{ __('Sign in') }}
                </a>
            @endauth
        </div>

        <div class="mt-10 rounded-lg border border-gray-200 bg-white p-6">
            <h2 class="text-base font-semibold text-gray-900">{{ __('How it works') }}</h2>
            <ol class="mt-3 list-decimal space-y-2 pl-5 text-sm text-gray-700">
                <li>{{ __('You record a meeting and drop the audio file in your Drive folder.') }}</li>
                <li>{{ __('OpenClaw transcribes and generates structured minutes.') }}</li>
                <li>{{ __('ClawScribe lists your minutes, sorted by date.') }}</li>
            </ol>
        </div>
    </div>
</x-guest-layout>
