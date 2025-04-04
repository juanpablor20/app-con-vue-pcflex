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
                <th>Tipo de Equipo</th>
                <th>Caracterisicas</th>
                <th>Numero de Seirie</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipments as $equipment)
            <tr>
                <td>{{ $equipment->id }}</td>
                <td>{{ $equipment->type_equi }}</td>
                <td>{{ $equipment->characteristics }}</td>
                <td>{{ $equipment->serie_equi  }}</td>
                <td>{{ $equipment->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
