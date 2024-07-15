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
            'ID',
            'IA Name',
            'CBBO Name',
          
            'CBBO Expert Name',
            'CBBO Type',
            'Designation',
            'ED Qualification',
            'Experience',
            'State',
            'Block',
            'District',
            'Contact No',
            'Email ID',
        ];
    }
}
