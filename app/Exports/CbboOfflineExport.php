<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class CbboOfflineExport implements FromCollection
{
    public function collection()
    {
        return DB::table('cbbo_offline')->get();
    }
}
