<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dishes</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .language-links {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .language-links a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }
        .language-links a:hover {
            text-decoration: underline;
        }
        .language-links span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dishes</h1>

        <!-- Textual Links for Language Switching -->
        <div class="language-links">
            <span>Change Language:</span>
            <a href="{{ url()->current() }}?lang=en" {{ $currentLocale === 'en' ? 'style=font-weight:bold;' : '' }}>English</a> |
            <a href="{{ url()->current() }}?lang=fr" {{ $currentLocale === 'fr' ? 'style=font-weight:bold;' : '' }}>French</a> |
            <a href="{{ url()->current() }}?lang=hr" {{ $currentLocale === 'hr' ? 'style=font-weight:bold;' : '' }}>Croatian</a>
        </div>

        <!-- Table of Dishes -->
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Tags</th>
                    <th>Ingredients</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dishes as $dish)
                <tr>
                    <td>{{ $dish['title'] ?? 'N/A' }}</td>
                    <td>{{ $dish['description'] ?? 'N/A' }}</td>
                    <td>
                        @if ($dish['category'])
                            {{ $dish['category']['title'] ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @foreach($dish['tags'] as $tag)
                            {{ $tag['title'] ?? 'N/A' }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($dish['ingredients'] as $ingredient)
                            {{ $ingredient['title'] ?? 'N/A' }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
