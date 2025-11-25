<?php

namespace Database\Seeders;

use App\Models\Tingkat;
use App\Models\Variabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariableTingkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variabels = [
            [
                'kode' => 'I',
                'nama' => 'PERENCANAAN PEMBANGUNAN DAERAH',
                'urutan' => 1,
                'tingkat' => [
                    1 => 'Penentuan Kegiatan yang diprioritaskan dalam dokumen perencanaan tahunan (Renja/RKPD) dilakukan tanpa ada kriteria yang terukur.',
                    2 => 'Penentuan kegiatan yang diprioritaskan dalam dokumen rencana tahunan dilakukan berdasarkan analisis terhadap hasil (outcome) apa yang akan dicapai kegiatan tersebut.',
                    3 => 'Penentuan prioritas kegiatan dalam dokumen rencana tahunan dilakukan berdasarkan analisis hasil (outcome) dan analisis kemampuan kegiatan menghasilkan hasil (outcome).',
                    4 => 'Penentuan prioritas kegiatan dilakukan berdasarkan analisis yang membandingkan hasil (outcome) yang akan dicapai antara satu alternatif kegiatan dengan alternatif kegiatan yang lain.',
                    5 => 'Penentuan prioritas kegiatan dalam dokumen tahunan dilakukan dengan perbandingan hasil (outcome) antara satu alternatif kegiatan dengan alternatif kegiatan yang lain dan dibantu dengan teknologi informasi.',
                ],
            ],
            [
                'kode' => 'II',
                'nama' => 'MONITORING DAN PENGENDALIAN PELAKSANAAN TUGAS PERANGKAT DAERAH',
                'urutan' => 2,
                'tingkat' => [
                    1 => 'Monitoring dan pengendalian dilakukan dengan cara sederhana dan tidak terstruktur.',
                    2 => 'Monitoring dan pengendalian dilakukan secara berkala dengan fokus yang ditentukan',
                    3 => 'Monitoring dan pengendalian dilakukan secara berkala dengan kriteria penyimpangan yang terstandarisasi pada setiap tahap kegiatan.',
                    4 => 'Monitoring dan pengendalian dilakukan secara berkala dengan kriteria penyimpangan yang terstandarisasi dan diikuti dengan umpan balik berupa perbaikan yang terdokumentasi dengan baik.',
                    5 => 'Monitoring dan pengendalian dilakukan secara sistematis, terstandarisasi termasuk umpan balik yang didukung oleh penggunaan teknologi informasi berbasis internet',
                ],
            ],
            [
                'kode' => 'III',
                'nama' => 'PENJAMINAN MUTU LAYANAN PERANGKAT DAERAH',
                'urutan' => 3,
                'tingkat' => [
                    1 => 'Tidak ada penjaminan mutu atas produk yang dihasilkan dan atas proses kerja yang dilakukan.',
                    2 => 'Penjaminan mutu produk dan proses kerja dilakukan secara berkala namun tidak mempunyai standar mutu produk dan proses yang ditetapkan.',
                    3 => 'Mutu produk dan proses sudah distandarisasi dan dilakukan pengujian secara berkala secara internal.',
                    4 => 'Penjaminan mutu produk dan proses sudah distandarisasi serta dilakukan pengukuran/pengujian secara berkala oleh tenaga yang bersertifikat.',
                    5 => 'Penjaminan mutu produk dan proses dilakukan terstandarisasi dan berkala oleh tenaga ahli bersertifikat serta didukung oleh teknologi informasi berbasis internet.',
                ],
            ],
            [
                'kode' => 'IV',
                'nama' => 'STANDAR OPERASIONAL PROSEDUR (SOP) PELAYANAN PERANGKAT DAERAH',
                'urutan' => 4,
                'tingkat' => [
                    1 => 'Tidak ada definisi resmi proses pelaksanaan pekerjaan pada perangkat daerah.',
                    2 => 'Definisi proses organisasi sudah dituangkan dalam standar operasi prosedur (SOP).',
                    3 => 'Definisi proses organisasi sudah dituangkan ke dalam SOP dan telah dilakukan evaluasi berkala terhadap penerapan SOP.',
                    4 => 'Definisi proses organisasi sudah dituangkan dalam SOP, sudah dievaluasi secara berkala dan dilakukan tindak lanjut terhadap hasil evaluasi penerapan SOP berupa tindakan koreksi atau perbaikan SOP.',
                    5 => 'Definisi proses organisasi sudah dituangkan dalam SOP dan sudah dilakukan evaluasi serta tindak lanjut, kemudian disesuaikan dengan kebutuhan/keluhan pelanggan serta didukung oleh teknologi berbasis internet.',
                ],
            ],
            [
                'kode' => 'V',
                'nama' => 'PENDIDIKAN DAN PELATIHAN APARATUR',
                'urutan' => 5,
                'tingkat' => [
                    1 => 'Belum ada dokumen resmi rencana kebutuhan pendidikan dan pelatihan pada perangkat daerah yang bersangkutan.',
                    2 => 'Dokumen rencana kebutuhan pengembangan pegawai sudah tersusun secara parsial untuk jabatan tertentu.',
                    3 => 'Dokumen rencana kebutuhan pengembangan pegawai disusun untuk seluruh jabatan.',
                    4 => 'Rencana pengembangan pegawai dievaluasi secara regular dan seluruh pengembangan pegawai sudah dilaksanakan sesuai dengan dokumen rencana pengembangan pegawai yang sudah ditetapkan.',
                    5 => 'Hasil (outcome) pengembangan pegawai dievalusi secara regular sebagai umpan balik.',
                ],
            ],
            [
                'kode' => 'VI',
                'nama' => 'ANALISIS KEBIJAKAN DAN PEMECAHAN MASALAH TUGAS PERANGKAT DAERAH',
                'urutan' => 6,
                'tingkat' => [
                    1 => 'Analisis kebijakan dan pemecahan masalah dilakukan secara sederhana dan dengan metode yang tidak terukur.',
                    2 => 'Analisis kebijakan yang berdampak ke publik dilakukan oleh tim internal perangkat daerah yang bersangkutan.',
                    3 => 'Analisis kebijakan dan pemecahan masalah yang berdampak ke publik dilakukan menggunakan metode/teknik ilmiah oleh tim internal dengan melibatkan instansi pemerintah terkait.',
                    4 => 'Analisis kebijakan dan pemecahan masalah yang Bersifat strategis/berdampak ke publik melibatkan tim ahli.',
                    5 => 'Analisis kebijakan dan pemecahan masalah strategis/berdampak ke publik melibatkan tim ahli dengan melakukan konsultasi publik dan analisis umpan balik yang terukur dan terdokumentasi.',
                ],
            ],
            [
                'kode' => 'VII',
                'nama' => 'MANAJEMEN SUMBER DAYA PERALATAN DAN PERLENGKAPAN KERJA YANG TERUKUR',
                'urutan' => 7,
                'tingkat' => [
                    1 => 'Penggunaan sumber daya dilakukan hanya berdasarkan ketentuan formal yang berlaku.',
                    2 => 'Penentuan penggunaan input proyek dilakukan berdasarkan analisis kebutuhan bahan/ sumber daya yang sudah ditetapkan.',
                    3 => 'Analisis kebutuhan input/sumber daya proyek sudah distandarisasi dengan proses ujicoba secara terbuka dan menggunakan metode ilmiah.',
                    4 => 'Penyediaan sumber daya dalam pelaksanaan proyek dimonitor secara ketat berdasarkan standar input sumber daya, SOP dan prosedur penjaminan mutu produk.',
                    5 => 'Penyediaan sumber daya dan pelaksanaan proyek dimonitor secara ketat berdasarkan SOP dan prosedur penjaminan mutu produk dan didukung oleh teknologi informasi berbasis internet.',
                ],
            ],
            [
                'kode' => 'VIII',
                'nama' => 'MANAJEMEN RESIKO PELAKSANAAN TUGAS APARATUR',
                'urutan' => 8,
                'tingkat' => [
                    1 => 'Belum ada manajemen resiko dalam pelaksanaan tugas pada perangkat daerah.',
                    2 => 'Sudah ada sebagian pegawai yang melakukan analisis resiko dalam pelaksanaan tugasnya, namun hanya bersifat individu.',
                    3 => 'Perangkat daerah sudah menetapkan prosedur pengelolaan resiko dalam pelaksanaan tugas tertentu yang dipandang mempunyai resiko tinggi.',
                    4 => 'Perangkat daerah sudah menetapkan prosedur pengelolaan resiko untuk seluruh tugas pada perangkat daerah yang bersangkutan, namun belum dilakukan evaluasi secara berkala.',
                    5 => 'Perangkat Daerah sudah menetapkan prosedur pengelolaan resiko dalam pelaksanaan tugas serta semua resiko dapat dikendalikan tanpa ada kerugian baik bagi pegawai maupun instansi.',
                ],
            ],
            [
                'kode' => 'IX',
                'nama' => 'PENGUKURAN KINERJA PERANGKAT DAERAH DAN APARATUR',
                'urutan' => 9,
                'tingkat' => [
                    1 => 'Belum ada target/rencana kinerja perangkat daerah yang terukur',
                    2 => 'Sudah ada target kinerja perangkat daerah, tapi belum konsisten mengacu dokumen perencanaan daerah.',
                    3 => 'Sudah ada target kinerja perangkat daerah yang konsisten dengan dokumen perencanaan',
                    4 => 'Target kinerja perangkat daerah sudah dilakukan pengukuran pencapaiannya.',
                    5 => 'Pencapaian target kinerja perangkat daerah sudah diukur dan sudah tercapai dengan baik (diatas 90%) serta telah dilakukan evaluasi pencapaian target kinerja serta didukung dengan teknologi informasi.',
                ],
            ],
            [
                'kode' => 'X',
                'nama' => 'PENGEMBANGAN INOVASI LAYANAN PERANGKAT DAERAH',
                'urutan' => 10,
                'tingkat' => [
                    1 => 'Belum ada rencana pengembangan produk yang akan dilakukan secara sistematis.',
                    2 => 'Pengembangan produk dilakukan dengan mengadopsi inovasi yang dikembangkan oleh daerah lain (replikasi inovasi).',
                    3 => 'Telah disusun rencana pengembangan inovasi baik jenis, mutu maupun metodenya',
                    4 => 'Telah ada inovasi yang dikembangkan sendiri oleh perangkat daerah yang bersangkutan.',
                    5 => 'Perangkat daerah sudah mempunyai program pengkajian dan inovasi secara terencana dan berkelanjutan.',
                ],
            ],
            [
                'kode' => 'XI',
                'nama' => 'BUDAYA ORGANISASI PERANGKAT DAERAH',
                'urutan' => 11,
                'tingkat' => [
                    1 => 'Belum ada budaya organisasi pada perangkat daerah.',
                    2 => 'Sudah ada slogan-slogan yang menggambarkan nilai organisasi pada perangkat daerah yang bersangkutan',
                    3 => 'Sudah ada dokumen budaya organisasi yang resmi menggambarkan nilai-nilai, sikap dan perilaku di perangkat daerah yang bersangkutan.',
                    4 => 'Sudah ada program internalisasi budaya organisasi yang berkelanjutan berdasarkan dokumen resmi.',
                    5 => 'Budaya organisasi sudah tercermin dalam sikap dan perilaku pegawai pada perangkat daerah yang bersangkutan berdasarkan hasil evaluasi secara rutin dan berkelanjutan.',
                ],
            ],
        ];

        foreach ($variabels as $variabelData) {
            $variabel = Variabel::create([
                'kode_variabel' => $variabelData['kode'],
                'nama_variabel' => $variabelData['nama'],
                'urutan' => $variabelData['urutan'],
            ]);

            foreach ($variabelData['tingkat'] as $tingkatNum => $deskripsi) {
                Tingkat::create([
                    'variabel_id' => $variabel->id,
                    'tingkat' => $tingkatNum,
                    'deskripsi_indikator' => $deskripsi,
                ]);
            }
        }
    }
}