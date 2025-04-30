<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Member::all()->map(function ($member) {
            return [
                'Associado' => $member->name,
                'Matrícula' => $member->registration_number
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nome do Associado',
            'Matrícula',
        ];
    }
}
