<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->warn('Tidak ada user di database. Silakan buat user terlebih dahulu.');
            return;
        }

        $laporans = [
            [
                'user_id' => $user->id,
                'nama_karyawan' => 'Max Verstappen',
                'jenis_laporan' => 'sakit',
                'tanggal_mulai' => Carbon::now()->subDays(5),
                'tanggal_selesai' => Carbon::now()->subDays(3),
                'keterangan' => 'Sakit demam dan flu',
                'status' => 'disetujui',
            ],
            [
                'user_id' => $user->id,
                'nama_karyawan' => 'Sergio Perez',
                'jenis_laporan' => 'cuti',
                'tanggal_mulai' => Carbon::now()->addDays(2),
                'tanggal_selesai' => Carbon::now()->addDays(5),
                'keterangan' => 'Cuti tahunan untuk liburan keluarga',
                'status' => 'pending',
            ],
            [
                'user_id' => $user->id,
                'nama_karyawan' => 'Christian Horner',
                'jenis_laporan' => 'dinas_luar',
                'tanggal_mulai' => Carbon::now(),
                'tanggal_selesai' => Carbon::now()->addDays(3),
                'keterangan' => 'Kunjungan ke pabrik Honda di Jepang',
                'status' => 'disetujui',
            ],
            [
                'user_id' => $user->id,
                'nama_karyawan' => 'Adrian Newey',
                'jenis_laporan' => 'izin',
                'tanggal_mulai' => Carbon::now()->subDay(),
                'tanggal_selesai' => Carbon::now()->subDay(),
                'keterangan' => 'Izin keperluan keluarga',
                'status' => 'disetujui',
            ],
            [
                'user_id' => $user->id,
                'nama_karyawan' => 'Helmut Marko',
                'jenis_laporan' => 'sakit',
                'tanggal_mulai' => Carbon::now(),
                'tanggal_selesai' => Carbon::now()->addDay(),
                'keterangan' => 'Sakit kepala migrain',
                'status' => 'pending',
            ],
        ];

        foreach ($laporans as $laporan) {
            Laporan::create($laporan);
        }

        $this->command->info('✓ 5 data laporan berhasil dibuat!');
    }
}

