<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AgriculturalImport implements ToModel, WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {
        // Initialize an empty array to store column-value pairs
        $data = [];

        // Define all columns with their respective indices
     // Ensure the column name in the script matches exactly with the database schema
$columns = [
    'id', 'Implementing Agency', 'user_id', 'State Category', 'IA Allocation year', 'Allocation Year to CBBO',
    'State', 'State_lgd', 'District', 'Block', 'Block Code', 'Block Name LGD', 'District Code', 'District Name LGD',
    'Is Tribal District', 'Is Aspirational District', 'CBBO Name', 'CBBO Unique ID', 'ODOP', 'Doing ODOP Crop',
    'Allocation Category Type', 'Primary Crop', 'Secondary Crop Approved by DMC', 'Secondary Crop',
    'DMC Approval Status', 'Primary Crop Approved by DMC', 'Type of Promotion Agency',
    'Status Board Member Identification', 'Status of Baseline survey', 'FPO Registered',
    'FPO Intervention Crops', 'FPO Name', 'FPO PAN NO', 'FPO TAN Number', 'FPO Office Village Name',
    'Udyog Aadhaar available', 'FPO Post Office', 'FPO Registration No', 'FPO Office PIN Code',
    'FPO_Office_Address', 'Bank Name', 'Bank Branch Name', 'IFSC CODE', 'Name of CA (First Name Last Name SurName)',
    'Bank Account Number', 'Mobile Number of CA', 'FPO Udyog Aadhaar', 'Email Id of CA',
    'Status CEO Appointment', 'CEO Appointment Date', 'FPO CEO Name (First Name Last Name SurName)',
    'FPO CEO Mobile No.', 'FPO CEO Email Id', 'Status Accountant Appointment', 'FPO Accountant Date',
    'FPO Accountant Mobile No.', 'FPO Accountant Name', 'FPO Accountant Email Id', 'Number of Training conducted for CEO',
    'Number of Training Farmers', 'Number of Training conducted for Accountants'
];


        // Iterate through each column
        foreach ($columns as $index => $column) {
            // Check if the column exists in the $row array
            if (isset($row[$index])) {
                // If the value is not empty, assign it; otherwise, assign null
                $data[$column] = !empty($row[$index]) ? $row[$index] : null;
            } else {
                // If the column is not set in $row, assign null
                $data[$column] = null;
            }
        }

        try {
            // Insert the data into the 'agricultural' table using Laravel's DB facade
            DB::table('agricultural')->insert($data);
        } catch (\Exception $e) {
            // Log any errors that occur during insertion
            Log::error('Error inserting data:', ['error' => $e->getMessage()]);
            throw $e; // Rethrow the exception for Laravel to handle
        }
    }

    public function batchSize(): int
    {
        return 1000; // Adjust batch size as needed
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust chunk size as needed
    }
}
