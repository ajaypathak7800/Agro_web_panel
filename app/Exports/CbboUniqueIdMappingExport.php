<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CbboUniqueIdMappingExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return DB::table('cbbo_unique_id_mapping')
                  ->orderBy('id', 'asc'); // Replace 'id' with your desired column
    }


    public function headings(): array
    {
        return [
            'ID',
            'CBBO Name',
            'CBBO Unique ID',
        ];
    }
}
