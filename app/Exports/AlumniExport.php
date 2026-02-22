<?php

namespace App\Exports;

use App\Models\AlumniProfile;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AlumniExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        return AlumniProfile::query()->with('user');
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIM',
            'Nama Lengkap',
            'Email',
            'Prodi',
            'Tahun Lulus',
            'No HP',
            'Alamat',
        ];
    }

    /**
     * @param mixed $alumni
     * @return array
     */
    public function map($alumni): array
    {
        return [
            $alumni->nim,
            $alumni->nama_lengkap,
            optional($alumni->user)->email ?? '',
            $alumni->prodi,
            $alumni->tahun_lulus,
            $alumni->no_hp,
            $alumni->alamat,
        ];
    }
}
