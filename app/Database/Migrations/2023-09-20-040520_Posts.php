<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'post_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'varchar',
                'constraint' => 25,
            ],
            'post_title' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            // hello-world : id 1
            // article/detail/id/1
            // article/detail/id/hello-world
            'post_title_seo' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'post_status' => [
                'type' => 'enum',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'post_type' => [
                'type' => 'enum',
                'constraint' => ['article', 'page'],
                'default' => 'article'
            ],
            'post_thumbnail' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'post_description' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'post_content' => [
                'type' => 'longtext',
            ],
            'post_time timestamp default now()'
        ]);

        $this->forge->addForeignKey('username', 'admin', 'username');
        $this->forge->addKey('post_id', TRUE);
        $this->forge->createTable('posts');
    }

    public function down()
    {
        //
        $this->forge->dropTable('posts');
    }
}