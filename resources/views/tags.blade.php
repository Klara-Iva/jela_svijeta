<!DOCTYPE html>
<html>
<head>
    <title>Tags</title>
</head>
<body>
    <h1>Tags</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Slug</th>
            <th>Title (EN)</th>
            <th>Title (FR)</th>
            <th>Title (HR)</th>
        </tr>
        @foreach($tags as $tag)
            @php
                $translations = DB::table('tag_translations')->where('tag_id', $tag->id)->get();
            @endphp
            <tr>
                <td>{{ $tag->id }}</td>
                <td>{{ $tag->slug }}</td>
                @foreach($translations as $translation)
                    <td>{{ $translation->title }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>
