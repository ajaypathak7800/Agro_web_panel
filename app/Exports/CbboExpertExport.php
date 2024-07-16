<?php

namespace App\Exports;


use App\Models\CbboExpert;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CbboExpertExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return CbboExpert::all();
    }

    public function headings(): array
    {
        return [
          
        ];
    }
}
