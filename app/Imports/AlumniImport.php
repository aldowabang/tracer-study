<?php

namespace App\Imports;

use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Require minimal info
        if (!isset($row['nim']) || !isset($row['nama_lengkap'])) {
            return null;
        }

        // 1. Ensure user exists (create if not exist)
        $email = $row['email'] ?? ($row['nim'] . '@alumni.example.com');
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $row['nama_lengkap'],
                'password' => Hash::make($row['nim']), // Default password is NIM
                'role' => 'alumni'
            ]
        );

        // 2. Ensure profile doesn't exist
        if (AlumniProfile::where('user_id', $user->id)->exists() || AlumniProfile::where('nim', $row['nim'])->exists()) {
             return null; // Skip if already exists
        }

        // 3. Create Alumni Profile
        return new AlumniProfile([
            'user_id'      => $user->id,
            'nim'          => $row['nim'],
            'nama_lengkap' => $row['nama_lengkap'],
            'prodi'        => $row['prodi'] ?? 'S1 Sistem Informasi',
            'tahun_lulus'  => $row['tahun_lulus'] ?? null,
            'no_hp'        => $row['no_hp'] ?? null,
            'alamat'       => $row['alamat'] ?? null,
        ]);
    }
}
