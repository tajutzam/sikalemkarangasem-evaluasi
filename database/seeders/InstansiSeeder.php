<?php

namespace Database\Seeders;

use App\Models\Instansi;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instansiList = [
            'Sekretariat Daerah',
            'Sekretariat Dewan Perwakilan Rakyat Daerah',
            'Inspektorat Daerah',
            'Dinas Pendidikan, Kepemudaan dan Olahraga',
            'Dinas Kesehatan',
            'Dinas Pekerjaan Umum dan Penataan Ruang',
            'Dinas Perumahan dan Kawasan Permukiman',
            'Dinas Sosial',
            'Dinas Ketenagakerjaan',
            'Dinas Pemadam Kebakaran',
            'Dinas Pemberdayaan Perempuan dan Perlindungan Anak',
            'Dinas Pengendalian Penduduk dan Keluarga Berencana',
            'Dinas Ketahanan Pangan',
            'Dinas Lingkungan Hidup',
            'Dinas Kependudukan dan Pencatatan Sipil',
            'Dinas Pemberdayaan Masyarakat dan Desa',
            'Dinas Perhubungan',
            'Dinas Komunikasi dan Informatika',
            'Dinas Koperasi, Usaha Mikro, kecil dan Menengah',
            'Dinas Kebudayaan',
            'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
            'Dinas Perpustakaan dan Kearsipan',
            'Dinas Pariwisata',
            'Dinas Perikanan',
            'Dinas Pertanian',
            'Dinas Perindustrian dan Perdagangan',
            'Satuan Polisi Pamong Praja',
            'Badan Perencanaan, Penelitian dan Pengembangan Daerah',
            'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia',
            'Badan Pengelola Keuangan dan Aset Daerah',
            'Kecamatan Kubu',
            'Kecamatan Abang',
            'Kecamatan Karangasem',
            'Kecamatan Manggis',
            'Kecamatan Sidemen',
            'Kecamatan Rendang',
            'Kecamatan Selat',
            'Kecamatan Bebandem',
            'Badan Kesatuan Bangsa, politik dan perlindungan Masyarakat',
            'Badan Penanggulangan Bencana Daerah',
        ];

        foreach ($instansiList as $namaInstansi) {
            Instansi::create([
                'nama_instansi' => $namaInstansi,
            ]);
        }
    }
}
