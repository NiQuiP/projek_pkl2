<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Absensi extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'instansi_pendidikan' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'last_login timestamp default now()'

        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('absensi', TRUE);
    }

    public function down()
    {
        //
        $this->forge->dropTable('absensi');
    }
}