<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Numero de ficha</th>
                <th>Programa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($indexCards as $indexCard)
            <tr>
                <td>{{ $indexCard->id }}</td>
                <td>{{ $indexCard->number }}</td>
                <td>{{ $indexCard->programs?->names_pro }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>