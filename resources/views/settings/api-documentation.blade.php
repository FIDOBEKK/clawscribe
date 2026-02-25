<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('API documentation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-8">
                    <section class="space-y-3">
                        <h3 class="text-base font-semibold">{{ __('Authentication') }}</h3>
                        <p class="text-sm text-gray-700">
                            {{ __('Use a personal access token from API tokens and send it as a Bearer token.') }}
                        </p>
                        <pre class="rounded bg-gray-900 p-4 text-xs text-gray-100 overflow-x-auto"><code>Authorization: Bearer YOUR_TOKEN</code></pre>
                    </section>

                    <section class="space-y-3">
                        <h3 class="text-base font-semibold">GET /api/user</h3>
                        <p class="text-sm text-gray-700">{{ __('Returns the authenticated user.') }}</p>
                        <pre class="rounded bg-gray-900 p-4 text-xs text-gray-100 overflow-x-auto"><code>curl -X GET "$APP_URL/api/user" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN"</code></pre>
                    </section>

                    <section class="space-y-3">
                        <h3 class="text-base font-semibold">GET /api/v1/me/minutes-preferences</h3>
                        <p class="text-sm text-gray-700">{{ __('Returns instructions, template metadata and extracted example texts for the current user.') }}</p>
                        <pre class="rounded bg-gray-900 p-4 text-xs text-gray-100 overflow-x-auto"><code>curl -X GET "$APP_URL/api/v1/me/minutes-preferences" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN"</code></pre>
                    </section>

                    <section class="space-y-3">
                        <h3 class="text-base font-semibold">POST /api/v1/minutes</h3>
                        <p class="text-sm text-gray-700">{{ __('Creates or updates a minute by source_file_id for the current user.') }}</p>
                        <div class="rounded border border-gray-200 p-4 text-sm">
                            <div class="font-medium">{{ __('Request body') }}</div>
                            <ul class="mt-2 list-disc ps-5 space-y-1 text-gray-700">
                                <li><span class="font-mono">source_file_id</span> <span class="text-gray-500">(required, string)</span></li>
                                <li><span class="font-mono">occurred_at</span> <span class="text-gray-500">(required, date)</span></li>
                                <li><span class="font-mono">title</span> <span class="text-gray-500">(required, string)</span></li>
                                <li><span class="font-mono">markdown</span> <span class="text-gray-500">(required, string)</span></li>
                                <li><span class="font-mono">drive_referat_path</span> <span class="text-gray-500">(optional, string)</span></li>
                                <li><span class="font-mono">drive_audio_path</span> <span class="text-gray-500">(optional, string)</span></li>
                            </ul>
                        </div>
                        <pre class="rounded bg-gray-900 p-4 text-xs text-gray-100 overflow-x-auto"><code>curl -X POST "$APP_URL/api/v1/minutes" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "source_file_id": "file-123",
    "occurred_at": "2026-02-25T08:30:00+01:00",
    "title": "Styremøte",
    "markdown": "# Oppsummering\n\nInnhold...",
    "drive_referat_path": "Referater/2026-02-25.md",
    "drive_audio_path": "Lyd/2026-02-25.m4a"
  }'</code></pre>
                        <div class="rounded border border-gray-200 p-4 text-sm text-gray-700">
                            <p><span class="font-medium">201</span> {{ __('when a new minute is created.') }}</p>
                            <p><span class="font-medium">200</span> {{ __('when an existing minute is updated (same source_file_id).') }}</p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
