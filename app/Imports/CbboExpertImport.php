<?php

namespace App\Imports;

use App\Models\CbboExpert;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;

class CbboExpertImport implements ToModel
{
    public function model(array $row)
    {
        // Assuming 'id' is the first column in your Excel file
     // Adjust according to your Excel structure

        return new CbboExpert([
           'id'=> $row[0],
            'ia_name' => $row[1],
            'cbbo_name' => $row[2],
            'cbbo_expert_name' => $row[3],
            'cbbo_type' => $row[4],
            'designation' => $row[5],
            'ed_qualification' => $row[6],
            'experience' => $row[7],
            'state' => $row[8],
            'block' => $row[9],
            'district' => $row[10],
            'contact_no' => $row[11],
            'email_id' => $row[12],
        ]);
    }
}
