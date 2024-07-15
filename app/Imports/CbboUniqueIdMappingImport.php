<?php
namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CbboUniqueIdMappingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        DB::table('cbbo_unique_id_mapping')->insert([
            'id' => $row['id'],

            'cbbo_name' => $row['cbbo_name'],
            'cbbo_unique_id' => $row['cbbo_unique_id'],
        ]);
    }
}
