<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class CbboOfflineImport implements ToModel, WithHeadingRow
{
    private $hasHeadingRow;

    public function __construct($hasHeadingRow = true)
    {
        $this->hasHeadingRow = $hasHeadingRow;
    }

    public function model(array $row)
    {
        if ($this->hasHeadingRow) {
            // With headings
            $id = $row['id'];
            $jsonData = json_decode($row['data'], true);
            $image = $row['image'];
        } else {
            // Without headings
            $id = $row[0];
            $jsonData = json_decode($row[1], true);
            $image = $row[2];
        }

        if (is_array($jsonData)) {
            $jsonData = json_encode($jsonData); // Convert back to JSON string if decoded successfully
        } else {
            $jsonData = null; // Handle case where JSON decoding fails
        }

        DB::table('cbbo_offline')->insert([
            'id' => $id,
            'data' => $jsonData, // Insert JSON data as a string
            'image' => $image, // Image file path
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'is_active' => 1,
        ]);
    }
}
