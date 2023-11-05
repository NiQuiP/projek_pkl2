<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa_mahasiswa';
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'username',
        'nama_lengkap',
        'nim',
        '',
        'email',
        'password',
        'nama_lengkap',
        'token'
    ];


    /** untuk ambil data */
    public function getData($parameter)
    {
        $builder = $this->table($this->table);
        $builder->where('username', $parameter);
        $builder->orWhere('email', $parameter);
        $query = $builder->get();
        return $query->getRowArray();
    }

    /** untuk update /simpan data */
    public function updateData($data)
    {
        $builder = $this->table($this->table);
        if ($builder->save($data)) {
            return true;
        } else {
            return false;
        }
    }
}