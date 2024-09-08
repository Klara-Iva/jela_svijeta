<!DOCTYPE html>
<html>
<head>
    <title>Ingredients</title>
</head>
<body>
    <h1>Ingredients</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Slug</th>
            <th>Title (EN)</th>
            <th>Title (FR)</th>
            <th>Title (HR)</th>
        </tr>
        @foreach($ingredients as $ingredient)
            @php
                $translations = DB::table('ingredient_translations')->where('ingredient_id', $ingredient->id)->get();
            @endphp
            <tr>
                <td>{{ $ingredient->id }}</td>
                <td>{{ $ingredient->slug }}</td>
                @foreach($translations as $translation)
                    <td>{{ $translation->title }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>
