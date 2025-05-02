<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Usuários PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Lista de Usuários</h2>
    <table>
        <thead>
            <tr>
                <th>Nickname</th>
                <th>Nome</th>
                <th>Matrícula</th>
                <th>Data de Nascimento</th>
                <th>Nível</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->nickname }}</td>
                    <td>{{ $user->dependent ? $user->dependent->name : ($user->member ? $user->member->name : 'Não é um associado nem um dependente') }}
                    </td>
                    <td>{{ $user->dependent ? $user->dependent->registration_number : ($user->member ? $user->member->registration_number : 'Não possui') }}
                    </td>
                    <td>
                        {{ $user->birth_date->format('d/m/Y') }}
                    </td>
                    <td>{{ $user->role === 'admin' ? 'Administrador' : ($user->role === 'management' ? 'Gerência' : ($user->role === 'member' ? 'Associado' : ($user->role === 'dependent' ? 'Dependente' : 'Não possui'))) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
