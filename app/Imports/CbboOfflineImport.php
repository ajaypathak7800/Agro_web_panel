<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class CbboOfflineImport implements ToModel
{
    public function model(array $row)
    {
        // Assuming $row[0] is ID, $row[1] is JSON data, $row[2] is image file path
        $jsonData = json_decode($row[1], true); // Decode JSON data
        
        if (is_array($jsonData)) {
            $jsonData = json_encode($jsonData); // Convert back to JSON string if decoded successfully
        } else {
            $jsonData = null; // Handle case where JSON decoding fails
        }

        DB::table('cbbo_offline')->insert([
            'id' => $row[0],
            'data' => $jsonData, // Insert JSON data as a string
            'image' => $row[2], // Image file path
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'is_active' => 1,
        ]);
    }
}
