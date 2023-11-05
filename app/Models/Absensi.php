<?php

namespace App\Models;

use CodeIgniter\Model;

class Absensi extends Model
{
    protected $table = "absensi";
    protected $primaryKey = "id";
    protected $allowedFields = [
        'nama_lengkap',
        'email',
        'nim_nis',
        'jenis_user',
        'instansi_pendidikan',
        'nama_instansi',
        'keterangan',
        'status',
        'lokasi',
        'foto_absen',
        'checkin_time',
        'checkout_time',
        'waktu_absen',
    ];

    public function getTotalAbsensiByStatus($nimUser, $status)
    {
        return $this->where('nim_nis', $nimUser)->where('status', $status)->countAllResults();
    }

}