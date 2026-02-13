<?php

namespace App\Http\Controllers;

use App\Http\Requests\MinutesPreferenceUpdateRequest;
use App\Http\Requests\MinutesPreferenceUploadExampleRequest;
use App\Http\Requests\MinutesPreferenceUploadTemplateRequest;
use App\Models\MinutesPreference;
use App\Services\DocumentTextExtractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MinutesPreferenceController extends Controller
{
    public function edit(Request $request): View
    {
        $preference = MinutesPreference::query()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $template = $preference->getFirstMedia('template');
        $examples = $preference->getMedia('examples');

        return view('settings.minutes-preferences', [
            'preference' => $preference,
            'template' => $template,
            'examples' => $examples,
        ]);
    }

    public function update(MinutesPreferenceUpdateRequest $request): RedirectResponse
    {
        $preference = MinutesPreference::query()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $preference->update($request->validated());

        return back();
    }

    public function uploadTemplate(MinutesPreferenceUploadTemplateRequest $request, DocumentTextExtractor $extractor): RedirectResponse
    {
        $preference = MinutesPreference::query()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $media = $preference
            ->addMediaFromRequest('template')
            ->toMediaCollection('template');

        $text = null;
        $error = null;

        try {
            $text = $extractor->extract($media->getPath(), (string) $media->mime_type, (string) $media->file_name);
        } catch (\Throwable $e) {
            $error = $e->getMessage();

            logger()->warning('Minutes template text extraction failed.', [
                'user_id' => $request->user()->id,
                'media_id' => $media->id,
                'mime_type' => $media->mime_type,
                'file_name' => $media->file_name,
                'exception' => get_class($e),
            ]);
        }

        $media->setCustomProperty('extracted_text', $text);
        $media->setCustomProperty('extracted_text_error', $error);
        $media->save();

        $preference->update([
            'template_extracted_text' => $text,
            'template_filename' => (string) $media->file_name,
            'template_mime_type' => (string) $media->mime_type,
        ]);

        return back();
    }

    public function uploadExample(MinutesPreferenceUploadExampleRequest $request, DocumentTextExtractor $extractor): RedirectResponse
    {
        $preference = MinutesPreference::query()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $media = $preference
            ->addMediaFromRequest('example')
            ->toMediaCollection('examples');

        $text = null;
        $error = null;

        try {
            $text = $extractor->extract($media->getPath(), (string) $media->mime_type, (string) $media->file_name);
        } catch (\Throwable $e) {
            $error = $e->getMessage();

            logger()->warning('Minutes example text extraction failed.', [
                'user_id' => $request->user()->id,
                'media_id' => $media->id,
                'mime_type' => $media->mime_type,
                'file_name' => $media->file_name,
                'exception' => get_class($e),
            ]);
        }

        $media->setCustomProperty('extracted_text', $text);
        $media->setCustomProperty('extracted_text_error', $error);
        $media->save();

        return back();
    }

    public function deleteMedia(Request $request, Media $media): RedirectResponse
    {
        $model = $media->model;

        abort_unless($model instanceof MinutesPreference, 404);
        abort_unless($model->user_id === $request->user()->id, 403);

        $collection = $media->collection_name;

        $media->delete();

        if ($collection === 'template') {
            $model->update([
                'template_extracted_text' => null,
                'template_filename' => null,
                'template_mime_type' => null,
            ]);
        }

        return back();
    }
}
