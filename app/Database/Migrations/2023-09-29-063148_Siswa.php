<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_lengkap' => [
                'type' => 'varchar',
                'constraint' => 25
            ],
            'nim' => [
                'type' => 'INT',
                'constraint' => 25
            ],
            'username' => [
                'type' => 'varchar',
                'constraint' => 25
            ],
            'jenis_kelamin' => [
                'type' => 'enum',
                'constraint' => ['pria', 'wanita']
            ],
            'no_telp' => [
                'type' => 'INT',
                'constraint' => 14
            ],
            'foto_profile' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'alamat_lengkap' => [
                'type' => 'longtext'
            ],
            'post_time timestamp default now()'
        ]);

        $this->forge->addForeignKey('username', 'user', 'username');
        // $this->forge->addForeignKey('email', 'user', 'email');
        $this->forge->addKey('user_id', TRUE);
        $this->forge->createTable('siswa_mahasiswa');
    }

    public function down()
    {
        //
        $this->forge->dropTable('siswa_mahasiswa');
    }
}