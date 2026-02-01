<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nim',
        'nama_lengkap',
        'prodi',
        'tahun_lulus',
        'no_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
