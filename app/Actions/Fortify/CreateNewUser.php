<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use App\Models\AlumniProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            'nim' => ['required', 'string', 'max:255', 'unique:alumni_profiles'],
            'tahun_lulus' => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . date('Y')],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
            ]);

            AlumniProfile::create([
                'user_id' => $user->id,
                'nim' => $input['nim'],
                'nama_lengkap' => $input['name'],
                'prodi' => 'S1 Sistem Informasi',
                'tahun_lulus' => $input['tahun_lulus'],
                'no_hp' => $input['no_hp'],
                'alamat' => $input['alamat'],
            ]);

            return $user;
        });
    }
}
