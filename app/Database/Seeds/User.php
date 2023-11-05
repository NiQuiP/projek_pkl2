<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        //
        $data = [
            'username' => 'user',
            'password' => password_hash('12345', PASSWORD_DEFAULT),
            'nama_lengkap' => 'aril',
            'email' => 'pain696987@gmail.com',
        ];
        $this->db->table('user')->insert($data);
    }
}