<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dishes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Ovaj stil dodaje malo više prostora između gumba kako bi bili vidljiviji */
        .language-buttons {
            margin-bottom: 20px;
        }
        .language-buttons .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1>Dishes</h1>

         <!-- Dodaj linkove za promjenu jezika ovdje -->
    <div>
        <a href="{{ url()->current() }}?lang=en">English</a> |
        <a href="{{ url()->current() }}?lang=fr">French</a> |
        <a href="{{ url()->current() }}?lang=hr">Croatian</a>
    </div>

        <!-- Dishes Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Ingredients</th>
                    <th>Tags</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dishes as $dish)
                    <tr>
                        <td>{{ $dish->translations->firstWhere('locale', request('lang', 'en'))->title }}</td>
                        <td>{{ $dish->translations->firstWhere('locale', request('lang', 'en'))->description }}</td>
                        <td>{{ $dish->category->translations->firstWhere('locale', request('lang', 'en'))->title }}</td>
                        <td>
                            @foreach ($dish->ingredients as $ingredient)
                                {{ $ingredient->translations->firstWhere('locale', request('lang', 'en'))->title }}@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($dish->tags as $tag)
                                {{ $tag->translations->firstWhere('locale', request('lang', 'en'))->title }}@if (!$loop->last), @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
