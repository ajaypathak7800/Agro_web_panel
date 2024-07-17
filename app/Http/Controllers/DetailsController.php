<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\details;
use App\Models\expertform;
use App\Exports\DetailsExport;
use App\Exports\ExportFpo;
use App\Exports\FromInputBusiness;
use App\Exports\ExpertFormData;
use App\Exports\kharifCrops;
use App\Exports\Expert;
use App\Exports\SelectedGstReturn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\NewhasConnectivity;
use App\Exports\NewSelectedGstReturn;
use App\Exports\NewFromInputBusiness;
use App\Exports\AwarenessProgram;
use App\Exports\NewkharifCrops;


class DetailsController extends Controller
{

    //hasConnectivity api

    // public function expert()
    // {
    //     return Excel::download(new Expert(), 'hasConnectivity.xlsx');
    // }

    //FromInputBusiness api
    public function FromInputBusiness()
    {
        return Excel::download(new FromInputBusiness(), 'FromInputBusiness.xlsx');
    }

    //ExpertFormData api
    public function expertFormData()
    {
        return Excel::download(new ExpertFormData(), 'ExpertFormData.xlsx');
    }

    //kharifCrops api
    public function kharifCrops()
    {
        return Excel::download(new kharifCrops(), 'kharifCrops.xlsx');
    }

    //kharifCrops api
    public function selectedGstReturn()
    {
        return Excel::download(new SelectedGstReturn(), 'selectedGstReturn.xlsx');
    }

    ///new sheet 
    public function newhasConnectivity()
    {
        return Excel::download(new NewhasConnectivity(), 'hasConnectivity.xlsx');
    }

    public function newselectedGstReturn()
    {
        return Excel::download(new NewSelectedGstReturn(), 'newselectedGstReturn.xlsx');
    }

    
    public function newfromInputBusiness()
    {
        return Excel::download(new NewFromInputBusiness(), 'newfromInputBusiness.xlsx');
    }

    public function awarenessProgram()
    {
        try {
            // Get the logged-in user's ID from the session
            $userId = session('ADMIN_ID');
    
            // Log the export action
            DB::table('user_action_track')->insert([
                'user_id' => $userId,
                'activity_type' => 'export',
                'action_table' => 'awarenessProgram', // Set the relevant table name or action description
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            // Perform the actual export
            return Excel::download(new AwarenessProgram(), 'awarenessProgram.xlsx');
        } catch (\Exception $e) {
            // Handle any exceptions during export
            return redirect()->back()->with('error', 'Error exporting file: ' . $e->getMessage());
        }
    }
    
    public function newkharifCrops()
{
    try {
        // Get the logged-in user's ID from the session
        $userId = session('ADMIN_ID');

        // Log the export action
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'export',
            'action_table' => 'newkharifCrops', // Set the relevant table name or action description
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Return the Excel download response
        return Excel::download(new NewkharifCrops(), 'newkharifCrops.xlsx');
    } catch (\Exception $e) {
        // Handle any exceptions during export
        return redirect()->back()->with('error', 'Error exporting file: ' . $e->getMessage());
    }
}








}