<?php

namespace App\Exports;

use App\Models\Dependent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DependentExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Dependent::with('member')->get()->map(function ($dependent) {
            return [
                'Dependente' => $dependent->name,
                'Matrícula' => $dependent->registration_number,
                'Associado' => $dependent->member->name
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nome do Dependente',
            'Matrícula',
            'Associado'
        ];
    }
}
