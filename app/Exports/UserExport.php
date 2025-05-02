<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::whereNot('role', 'admin')->get()->map(function ($user) {
            return [
                'Nickname' => $user->nickname,
                'Nome' => $user->dependent ? $user->dependent->name : ($user->member ? $user->member->name : 'Não é um associado nem um dependente'),
                'Matrícula' => $user->dependent ? $user->dependent->registration_number : ($user->member ? $user->member->registration_number : 'Não possui'),
                'Data de Nascimento' => $user->birth_date->format('d/m/Y'),
                'Nível' => $user->role === 'admin' ? 'Administrador' : ($user->role === 'management' ? 'Gerência' : ($user->role === 'member' ? 'Associado' : ($user->role === 'dependent' ? 'Dependente' : 'Não possui')))
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nickname',
            'Nome',
            'Matrícula',
            'Data de Nascimento',
            'Nível'
        ];
    }
}
