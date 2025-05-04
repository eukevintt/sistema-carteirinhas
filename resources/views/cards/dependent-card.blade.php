<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carteirinha Digital</title>
    <style>
        @page {
            size: 210mm 148mm;
            /* A5 Paisagem */
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 148mm;
            overflow: hidden;
        }

        .page {
            position: relative;
            width: 210mm;
            height: 148mm;
            overflow: hidden;
        }

        .page+.page {
            /* Apenas a segunda página quebra */
            page-break-before: always;
        }

        .background {
            width: 210mm;
            height: 148mm;
            position: absolute;
            z-index: -1;
        }

        .info {
            position: absolute;
            text-align: left;
            font-size: 15px;
            font-weight: bold;
            color: #000;
        }

        /* Nome */
        .nome {
            top: 88mm;
            /* Ajustado para alinhar ao espaço correto */
            left: 12mm;
            /* Ajustado para alinhar melhor */
            width: 100mm;
        }

        /* Matrícula */
        .matricula {
            top: 115mm;
            /* Ajustado para alinhar ao espaço correto */
            left: 12mm;
            /* Ajustado para alinhar melhor */
            width: 100mm;
        }

        /* Foto do usuário */
        .foto {
            position: absolute;
            top: 90mm;
            /* Ajustado para centralizar melhor */
            left: 150mm;
            width: 40mm;
            height: 40mm;
            object-fit: cover;
            border: 3px solid white;
        }

        .validade {
            top: 130mm;
            /* Ajuste conforme necessário */
            left: 12mm;
            font-size: 18px;
            font-weight: bold;
            color: #ff0000;
        }

        .dependentes {
            top: 20mm;
            /* Ajuste conforme necessário */
            left: 52%;
            width: 80mm;
            text-align: center;
            transform: translateX(-50%);
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Página 1: Frente da Carteirinha -->
    <div class="page">
        <img src="{{ storage_path('app/private/carteirinha-frente.jpg') }}" class="background">

        @if (!empty($user) && !empty($user->photo))
            <img src="{{ storage_path('app/' . $user->photo) }}" class="foto">
        @endif

        <!-- Nome e Matrícula -->
        <div class="info nome">{{ $dependent->name }}</div>
        <div class="info matricula">{{ $dependent->registration_number }}</div>

        <div class="info validade">
            Válido até: {{ \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y') }}
        </div>
    </div>

    <div class="page">
        <img src="{{ storage_path('app/private/carteirinha-verso-dependente.jpg') }}" class="background">

        <div class="info dependentes">
            Dependente de: {{ $dependent->member->name }}, com a matrícula {{ $dependent->member->registration_number }}
        </div>
    </div>

</body>

</html>
