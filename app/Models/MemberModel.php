<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'member_id';
    protected $allowedFields = [
        'member_id',
        'username',
        'no_hp',
        'email',
        'password',
        'nama_lengkap',
        'nim_nis',
        'jenis_kelamin',
        'foto',
        'instansi_pendidikan',
        'nama_instansi',
        'level',
        'is_verifikasi',
        'token'
    ];

    public function getTotalUser($jenis_user)
    {
        return $this->where('jenis_user', $jenis_user)->countAllResults();
    }

    public function getJumlahInstansi($jenis_user)
    {
        return $this->where('instansi_pendidikan', $jenis_user)->select('nama_instansi')->distinct()->countAllResults();
    }
}