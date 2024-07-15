<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Fetch existing emails to check for duplicates
        $existingEmails = DB::table('users')->pluck('email')->toArray();
        $newUsers = [];

        foreach ($rows as $row) {
            // Validate that required fields are present and not null
            if (empty($row['name']) || empty($row['email']) || empty($row['password'])) {
                continue; // Skip rows with missing required fields
            }

            $name = trim($row['name']);
            $email = trim($row['email']);
            $password = trim($row['password']);

            // Check if the email already exists in the database
            if (!in_array($email, $existingEmails)) {
                $newUsers[] = [
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password), // Hash the password
                ];
                $existingEmails[] = $email; // Add to existing emails to avoid duplicates in current import
            }
        }

        // Insert new users
        if (!empty($newUsers)) {
            DB::table('users')->insert($newUsers);
        }
    }
}
