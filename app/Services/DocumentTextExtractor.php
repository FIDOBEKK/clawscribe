<?php

namespace App\Services;

use Illuminate\Support\Str;
use Spatie\PdfToText\Pdf;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use Symfony\Component\Process\Process;

class DocumentTextExtractor
{
    public function extract(string $path, string $mimeType, string $originalName): string
    {
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (in_array($ext, ['md', 'markdown', 'txt'], true) || str_starts_with($mimeType, 'text/')) {
            return trim((string) file_get_contents($path));
        }

        if ($ext === 'pdf' || $mimeType === 'application/pdf') {
            return $this->extractPdf($path);
        }

        if ($ext === 'docx' || $mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            return $this->extractDocxViaPandoc($path);
        }

        // Fallback: best-effort treat as text.
        return trim((string) file_get_contents($path));
    }

    private function extractPdf(string $path): string
    {
        // Requires poppler-utils (pdftotext) installed on the server.
        $binary = config('services.pdftotext') ?: 'pdftotext';

        $text = Pdf::getText($path, $binary);

        return trim((string) $text);
    }

    private function extractDocxViaPandoc(string $path): string
    {
        // Requires pandoc installed on the server.
        $binary = config('services.pandoc') ?: 'pandoc';

        $tmp = (new TemporaryDirectory)->create();
        $out = $tmp->path('out.txt');

        $process = new Process([
            $binary,
            '--from=docx',
            '--to=plain',
            '--wrap=none',
            '-o',
            $out,
            $path,
        ]);

        $process->setTimeout(30);
        $process->run();

        $text = '';
        if ($process->isSuccessful() && file_exists($out)) {
            $text = (string) file_get_contents($out);
        }

        $tmp->delete();

        return trim(Str::of($text)->replace("\r\n", "\n"));
    }
}
