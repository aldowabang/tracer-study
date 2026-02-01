<?php

namespace Database\Seeders;

use App\Models\TracerOption;
use App\Models\TracerPeriod;
use App\Models\TracerQuestion;
use Illuminate\Database\Seeder;

class TracerStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat periode tracer study
        $period = TracerPeriod::create([
            'tahun_lulusan' => '2024',
            'judul' => 'Tracer Study S1 Sistem Informasi 2024',
            'tgl_mulai' => '2024-01-01',
            'tgl_selesai' => '2024-12-31',
            'is_active' => true,
        ]);

        // ========================================
        // BAGIAN A: IDENTITAS RESPONDEN
        // ========================================

        // A1. Tahun lulus
        TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f8',
            'pertanyaan' => 'Tahun lulus',
            'tipe' => 'number',
            'urutan' => 1,
            'wajib_diisi' => true,
        ]);

        // A2. NIM (opsional)
        TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f501',
            'pertanyaan' => 'NIM (opsional)',
            'tipe' => 'text',
            'urutan' => 2,
            'wajib_diisi' => false,
        ]);

        // A3. IPK saat lulus
        TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f502',
            'pertanyaan' => 'IPK saat lulus',
            'tipe' => 'number',
            'urutan' => 3,
            'wajib_diisi' => true,
        ]);

        // A4. Lama studi (tahun/bulan)
        TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f503',
            'pertanyaan' => 'Lama studi (tahun/bulan)',
            'tipe' => 'text',
            'urutan' => 4,
            'wajib_diisi' => true,
        ]);

        // A5. Jenis kelamin
        $q5 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f504',
            'pertanyaan' => 'Jenis kelamin',
            'tipe' => 'radio',
            'urutan' => 5,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q5->id, [
            ['label' => 'Laki-laki', 'value' => 'L'],
            ['label' => 'Perempuan', 'value' => 'P'],
        ]);

        // ========================================
        // BAGIAN B: STATUS SETELAH LULUS
        // ========================================

        // B6. Status saat ini
        $q6 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f401',
            'pertanyaan' => 'Status Anda saat ini',
            'tipe' => 'radio',
            'urutan' => 6,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q6->id, [
            ['label' => 'Bekerja', 'value' => 'bekerja'],
            ['label' => 'Wirausaha', 'value' => 'wirausaha'],
            ['label' => 'Melanjutkan studi', 'value' => 'studi'],
            ['label' => 'Belum bekerja', 'value' => 'belum_bekerja'],
        ]);

        // B7. Waktu tunggu mendapatkan pekerjaan pertama
        $q7 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f402',
            'pertanyaan' => 'Waktu tunggu mendapatkan pekerjaan pertama',
            'tipe' => 'radio',
            'urutan' => 7,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q7->id, [
            ['label' => '< 3 bulan', 'value' => 'kurang_3_bulan'],
            ['label' => '3–6 bulan', 'value' => '3_6_bulan'],
            ['label' => '6–12 bulan', 'value' => '6_12_bulan'],
            ['label' => '> 12 bulan', 'value' => 'lebih_12_bulan'],
        ]);

        // B8. Cara memperoleh pekerjaan
        $q8 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f403',
            'pertanyaan' => 'Cara memperoleh pekerjaan',
            'tipe' => 'radio',
            'urutan' => 8,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q8->id, [
            ['label' => 'Melamar langsung', 'value' => 'melamar_langsung'],
            ['label' => 'Rekomendasi/relasi', 'value' => 'relasi'],
            ['label' => 'Career center kampus', 'value' => 'career_center'],
            ['label' => 'Magang/MBKM', 'value' => 'magang_mbkm'],
            ['label' => 'Lainnya', 'value' => 'lainnya'],
        ]);

        // ========================================
        // BAGIAN C: PROFIL PEKERJAAN
        // ========================================

        // C9. Jenis instansi
        $q9 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f404',
            'pertanyaan' => 'Jenis instansi tempat bekerja',
            'tipe' => 'radio',
            'urutan' => 9,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q9->id, [
            ['label' => 'Pemerintah', 'value' => 'pemerintah'],
            ['label' => 'Swasta nasional', 'value' => 'swasta_nasional'],
            ['label' => 'Swasta multinasional', 'value' => 'swasta_multinasional'],
            ['label' => 'Startup', 'value' => 'startup'],
            ['label' => 'Wirausaha', 'value' => 'wirausaha'],
        ]);

        // C10. Posisi/Jabatan
        $q10 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f405',
            'pertanyaan' => 'Posisi/Jabatan Anda saat ini',
            'tipe' => 'checkbox',
            'urutan' => 10,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q10->id, [
            ['label' => 'System Analyst', 'value' => 'system_analyst'],
            ['label' => 'Programmer / Software Developer', 'value' => 'programmer'],
            ['label' => 'Data Analyst', 'value' => 'data_analyst'],
            ['label' => 'IT Support', 'value' => 'it_support'],
            ['label' => 'Business Analyst', 'value' => 'business_analyst'],
            ['label' => 'Konsultan IT', 'value' => 'konsultan_it'],
            ['label' => 'Lainnya', 'value' => 'lainnya'],
        ]);

        // C11. Rentang gaji pertama
        $q11 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f406',
            'pertanyaan' => 'Rentang gaji pertama Anda',
            'tipe' => 'radio',
            'urutan' => 11,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q11->id, [
            ['label' => '< Rp3.000.000', 'value' => 'kurang_3jt'],
            ['label' => 'Rp3.000.000 – Rp5.000.000', 'value' => '3jt_5jt'],
            ['label' => 'Rp5.000.000 – Rp7.000.000', 'value' => '5jt_7jt'],
            ['label' => '> Rp7.000.000', 'value' => 'lebih_7jt'],
        ]);

        // ========================================
        // BAGIAN D: KESESUAIAN BIDANG KERJA
        // ========================================

        // D12. Kesesuaian pekerjaan dengan bidang SI
        $q12 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f505',
            'pertanyaan' => 'Kesesuaian pekerjaan dengan bidang Sistem Informasi',
            'tipe' => 'radio',
            'urutan' => 12,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q12->id, [
            ['label' => 'Sangat sesuai', 'value' => 'sangat_sesuai'],
            ['label' => 'Sesuai', 'value' => 'sesuai'],
            ['label' => 'Cukup sesuai', 'value' => 'cukup_sesuai'],
            ['label' => 'Tidak sesuai', 'value' => 'tidak_sesuai'],
        ]);

        // D13. Tingkat pendidikan yang dibutuhkan
        $q13 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f506',
            'pertanyaan' => 'Tingkat pendidikan yang dibutuhkan pada pekerjaan Anda',
            'tipe' => 'radio',
            'urutan' => 13,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q13->id, [
            ['label' => 'Di bawah S1', 'value' => 'dibawah_s1'],
            ['label' => 'Setara S1', 'value' => 'setara_s1'],
            ['label' => 'Di atas S1', 'value' => 'diatas_s1'],
        ]);

        // ========================================
        // BAGIAN E: PENILAIAN KOMPETENSI LULUSAN (CPL)
        // ========================================

        $kompetensiList = [
            ['kode' => 'f1761', 'urutan' => 14, 'pertanyaan' => 'Etika profesi dan tanggung jawab'],
            ['kode' => 'f1762', 'urutan' => 15, 'pertanyaan' => 'Pemahaman konsep Sistem Informasi'],
            ['kode' => 'f1763', 'urutan' => 16, 'pertanyaan' => 'Analisis dan perancangan sistem informasi'],
            ['kode' => 'f1764', 'urutan' => 17, 'pertanyaan' => 'Pemrograman dan pengembangan aplikasi'],
            ['kode' => 'f1765', 'urutan' => 18, 'pertanyaan' => 'Basis data dan pengelolaan data'],
            ['kode' => 'f1766', 'urutan' => 19, 'pertanyaan' => 'Analisis data dan pengambilan keputusan'],
            ['kode' => 'f1767', 'urutan' => 20, 'pertanyaan' => 'Pemahaman proses bisnis organisasi'],
            ['kode' => 'f1768', 'urutan' => 21, 'pertanyaan' => 'Penguasaan teknologi informasi terkini'],
            ['kode' => 'f1769', 'urutan' => 22, 'pertanyaan' => 'Kemampuan berpikir kritis dan problem solving'],
            ['kode' => 'f1770', 'urutan' => 23, 'pertanyaan' => 'Kemampuan komunikasi lisan dan tulisan'],
            ['kode' => 'f1771', 'urutan' => 24, 'pertanyaan' => 'Kerja sama tim (teamwork)'],
            ['kode' => 'f1772', 'urutan' => 25, 'pertanyaan' => 'Kemampuan manajemen proyek TI'],
            ['kode' => 'f1773', 'urutan' => 26, 'pertanyaan' => 'Kemampuan adaptasi dan belajar mandiri'],
        ];

        foreach ($kompetensiList as $kompetensi) {
            $q = TracerQuestion::create([
                'tracer_period_id' => $period->id,
                'kode_dikti' => $kompetensi['kode'],
                'pertanyaan' => 'Seberapa besar peran perkuliahan dalam membekali kompetensi: ' . $kompetensi['pertanyaan'],
                'tipe' => 'scale',
                'urutan' => $kompetensi['urutan'],
                'wajib_diisi' => true,
            ]);

            $this->createOptions($q->id, [
                ['label' => '1 - Sangat Rendah', 'value' => '1'],
                ['label' => '2 - Rendah', 'value' => '2'],
                ['label' => '3 - Cukup', 'value' => '3'],
                ['label' => '4 - Tinggi', 'value' => '4'],
                ['label' => '5 - Sangat Tinggi', 'value' => '5'],
            ]);
        }

        // ========================================
        // BAGIAN F: RELEVANSI KURIKULUM
        // ========================================

        // F27. Kesesuaian kurikulum dengan kebutuhan dunia kerja
        $q27 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f601',
            'pertanyaan' => 'Kesesuaian kurikulum dengan kebutuhan dunia kerja',
            'tipe' => 'radio',
            'urutan' => 27,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q27->id, [
            ['label' => 'Sangat sesuai', 'value' => 'sangat_sesuai'],
            ['label' => 'Sesuai', 'value' => 'sesuai'],
            ['label' => 'Cukup sesuai', 'value' => 'cukup_sesuai'],
            ['label' => 'Tidak sesuai', 'value' => 'tidak_sesuai'],
        ]);

        // F28. Mata kuliah yang paling mendukung pekerjaan
        $q28 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f602',
            'pertanyaan' => 'Mata kuliah yang paling mendukung pekerjaan Anda',
            'tipe' => 'checkbox',
            'urutan' => 28,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q28->id, [
            ['label' => 'Analisis & Perancangan Sistem', 'value' => 'aps'],
            ['label' => 'Basis Data', 'value' => 'basis_data'],
            ['label' => 'Pemrograman Web', 'value' => 'pemrograman_web'],
            ['label' => 'Sistem Enterprise', 'value' => 'sistem_enterprise'],
            ['label' => 'Data Mining / BI', 'value' => 'data_mining_bi'],
            ['label' => 'Manajemen Proyek TI', 'value' => 'mptik'],
            ['label' => 'Lainnya', 'value' => 'lainnya'],
        ]);

        // F29. Mata kuliah yang perlu ditingkatkan
        TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f603',
            'pertanyaan' => 'Mata kuliah yang perlu ditingkatkan atau diperbarui',
            'tipe' => 'textarea',
            'urutan' => 29,
            'wajib_diisi' => false,
        ]);

        // ========================================
        // BAGIAN G: PENGALAMAN PEMBELAJARAN
        // ========================================

        // G30. Apakah Anda mengikuti kegiatan berikut?
        $q30 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f701',
            'pertanyaan' => 'Apakah Anda mengikuti kegiatan berikut?',
            'tipe' => 'checkbox',
            'urutan' => 30,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q30->id, [
            ['label' => 'Magang', 'value' => 'magang'],
            ['label' => 'MBKM', 'value' => 'mbkm'],
            ['label' => 'Organisasi mahasiswa', 'value' => 'organisasi'],
            ['label' => 'Penelitian', 'value' => 'penelitian'],
            ['label' => 'Sertifikasi IT', 'value' => 'sertifikasi'],
        ]);

        // G31. Seberapa besar kegiatan tersebut membantu kesiapan kerja
        $q31 = TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f702',
            'pertanyaan' => 'Seberapa besar kegiatan tersebut membantu kesiapan kerja?',
            'tipe' => 'radio',
            'urutan' => 31,
            'wajib_diisi' => true,
        ]);

        $this->createOptions($q31->id, [
            ['label' => 'Sangat membantu', 'value' => 'sangat_membantu'],
            ['label' => 'Membantu', 'value' => 'membantu'],
            ['label' => 'Cukup', 'value' => 'cukup'],
            ['label' => 'Tidak membantu', 'value' => 'tidak_membantu'],
        ]);

        // ========================================
        // BAGIAN H: KEPUASAN LULUSAN
        // ========================================

        $kepuasanList = [
            ['kode' => 'f801', 'urutan' => 32, 'pertanyaan' => 'Kualitas dosen'],
            ['kode' => 'f802', 'urutan' => 33, 'pertanyaan' => 'Metode pembelajaran'],
            ['kode' => 'f803', 'urutan' => 34, 'pertanyaan' => 'Fasilitas laboratorium'],
            ['kode' => 'f804', 'urutan' => 35, 'pertanyaan' => 'Layanan akademik'],
            ['kode' => 'f805', 'urutan' => 36, 'pertanyaan' => 'Bimbingan karier & alumni'],
        ];

        foreach ($kepuasanList as $kepuasan) {
            $q = TracerQuestion::create([
                'tracer_period_id' => $period->id,
                'kode_dikti' => $kepuasan['kode'],
                'pertanyaan' => 'Tingkat kepuasan Anda terhadap: ' . $kepuasan['pertanyaan'],
                'tipe' => 'radio',
                'urutan' => $kepuasan['urutan'],
                'wajib_diisi' => true,
            ]);

            $this->createOptions($q->id, [
                ['label' => 'Sangat Puas', 'value' => 'sangat_puas'],
                ['label' => 'Puas', 'value' => 'puas'],
                ['label' => 'Cukup', 'value' => 'cukup'],
                ['label' => 'Tidak Puas', 'value' => 'tidak_puas'],
            ]);
        }

        // ========================================
        // BAGIAN I: MASUKAN UNTUK PRODI
        // ========================================

        // I37. Kompetensi tambahan yang perlu dibekalkan
        TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f901',
            'pertanyaan' => 'Kompetensi tambahan yang perlu dibekalkan lulusan SI',
            'tipe' => 'textarea',
            'urutan' => 37,
            'wajib_diisi' => false,
        ]);

        // I38. Saran peningkatan kurikulum
        TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f902',
            'pertanyaan' => 'Saran peningkatan kurikulum',
            'tipe' => 'textarea',
            'urutan' => 38,
            'wajib_diisi' => false,
        ]);

        // I39. Saran peningkatan layanan prodi
        TracerQuestion::create([
            'tracer_period_id' => $period->id,
            'kode_dikti' => 'f903',
            'pertanyaan' => 'Saran peningkatan layanan prodi',
            'tipe' => 'textarea',
            'urutan' => 39,
            'wajib_diisi' => false,
        ]);
    }

    /**
     * Helper function to create options for a question
     */
    private function createOptions(int $questionId, array $options): void
    {
        foreach ($options as $index => $option) {
            TracerOption::create([
                'tracer_question_id' => $questionId,
                'label' => $option['label'],
                'value' => $option['value'],
                'urutan' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
