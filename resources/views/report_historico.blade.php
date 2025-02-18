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
                <th>fecha de Prestamos</th>
                <th>Fecha de devolucion</th>
                <th>Numero Documento</th>
                <th>Numero Serie</th>
                <th>Ambiente</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td>{{ $service->date_ser }}</td>
                <td>{{ $service->return_ser}} </td>
                <td>{{ $service->users->number_identification }}</td>
                <td>{{ $service->equipment->serie_equi }}</td>
                <td>{{ $service->environment->names }}</td>
                <td>{{ $service->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>