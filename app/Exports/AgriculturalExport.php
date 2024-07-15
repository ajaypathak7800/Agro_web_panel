<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgriculturalExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $agriculturalData = DB::select('SELECT * FROM agricultural');
        return collect($agriculturalData);
    }

    public function headings(): array
    {
        // Define headings for the Excel export
        return [
            'id',  'Implementing Agency', 'user_id', 'State Category', 'IA Allocation year', 'Allocation Year to CBBO',
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
       
      
    }
}
