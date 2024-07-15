<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FpoExport implements FromCollection, WithHeadings
{
    protected $fpos;

    public function __construct(Collection $fpos)
    {
        $this->fpos = $fpos;
    }

    public function collection()
    {
        return $this->fpos;
    }

    public function headings(): array
    {
        return [
            'id',
            'implementing_agency',
            'cbbo_name',
            // 'cbbo_unique_id',
            'state',
            'district', // Make sure this matches your database column name
            'block',
            'fpo_name',
            'number_shareholder',
            'f_register_n ',
            ' office_address',
            'ceo_name ',
            'account_n',
        ];
    }
}
