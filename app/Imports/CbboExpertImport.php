<?php
namespace App\Imports;

use App\Models\CbboExpert;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CbboExpertImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new CbboExpert([
            'id' => $row['id'], 
            'ia_name' => $row['ia_name'],
            'cbbo_name' => $row['cbbo_name'],
            // 'cbbo_unique_id' => $row['cbbo_unique_id'],
            'cbbo_expert_name' => $row['cbbo_expert_name'],
            'cbbo_type' => $row['cbbo_type'],
            'designation' => $row['designation'],
            'ed_qualification' => $row['ed_qualification'],
            'experience' => $row['experience'],
            'state' => $row['state'],
            'block' => $row['block'],
            'district' => $row['district'],
            'contact_no' => $row['contact_no'],
            'email_id' => $row['email_id'],
        ]);
    }
}
