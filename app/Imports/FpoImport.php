<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class FpoImport implements ToCollection
{
    /**
     * Validate if the row has all required fields.
     *
     * @param array $row
     * @return bool
     */
    private function isValidRow($row)
    {
        // Example validation: check for required fields
        return isset($row[1]) && !is_null($row[1]) && // implementing_agency
               isset($row[2]) && !is_null($row[2]) && // cbbo_name
               isset($row[3]) && !is_null($row[3]) && // state
               isset($row[4]) && !is_null($row[4]) && // district
               isset($row[5]) && !is_null($row[5]) && // block
               isset($row[6]) && !is_null($row[6]) && // fpo_name
               isset($row[11]) && !is_null($row[11]); // account_n
    }

    /**
     * Handle the collection of rows from Excel import.
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $index => $row) {
                // Validate required fields
                if (!$this->isValidRow($row)) {
                    continue; // Skip invalid rows
                }

                // Ensure $row[0] contains the 'id' value if necessary
                $id = isset($row[0]) ? $row[0] : null;

                // Insert data into database
                DB::table('master')->insert([
                    'id' => $id,
                    'implementing_agency' => $row[1],
                    'cbbo_name' => $row[2],
                    'state' => $row[3],
                    'district' => $row[4],
                    'block' => $row[5],
                    'fpo_name' => $row[6],
                    'number_shareholder' => $row[7] ?? null,
                    'f_register_n' => $row[8] ?? null,
                    'office_address' => $row[9] ?? null,
                    'ceo_name' => $row[10] ?? null,
                    'account_n' => $row[11],
                ]);

                // Log successful insertion
                Log::info('Inserted row: ', ['index' => $index, 'row' => $row->toArray()]);
            }

            DB::commit(); // Commit transaction if all rows are inserted successfully
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on exception
            Log::error('Error inserting row: ', ['error' => $e->getMessage()]);
        }
    }
}
