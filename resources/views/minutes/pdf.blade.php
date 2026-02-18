<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="utf-8">
    <title>{{ $minute->title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.5;
            margin: 28px;
        }

        h1 {
            font-size: 22px;
            margin: 0 0 8px;
        }

        .meta {
            color: #4b5563;
            margin: 0 0 16px;
        }

        h2,
        h3,
        h4 {
            margin-top: 18px;
            margin-bottom: 8px;
        }

        p,
        ul,
        ol,
        table,
        blockquote,
        pre {
            margin-top: 0;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            text-align: left;
        }

        code {
            font-family: Menlo, Monaco, Consolas, monospace;
            font-size: 11px;
        }

        pre {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px;
            white-space: pre-wrap;
            word-break: break-word;
        }
    </style>
</head>
<body>
    <h1>{{ $minute->title }}</h1>

    <p class="meta">
        {{ __('When:') }} {{ $minute->occurred_at?->format('Y-m-d H:i') }}
    </p>

    <div>
        {!! $minute->rendered_markdown !!}
    </div>
</body>
</html>
