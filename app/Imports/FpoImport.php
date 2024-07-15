<?php

// app/Imports/FpoImport.php
namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class FpoImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            DB::table('master')->insert([
                'id' => $row['id'],
                'implementing_agency' => $row['implementing_agency'],
                'cbbo_name' => $row['cbbo_name'],
                // 'cbbo_unique_id' => $row['cbbo_unique_id'],
                'state' => $row['state'],
                'district' => $row['district'], 
                'block' => $row['block'],
                'fpo_name' => $row['fpo_name'],
                'number_shareholder' => $row['number_shareholder'],
                'f_register_n' => $row['f_register_n'],
                'office_address' => $row['office_address'],
                'ceo_name' => $row['ceo_name'],
                'account_n' => $row['account_n'],
            ]);
        }
    }
}
