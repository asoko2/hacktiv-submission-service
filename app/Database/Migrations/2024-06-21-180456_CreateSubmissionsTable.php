<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubmissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'year' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'reason_rejected' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'reason_need_revision' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 1,
                'null' => true,
            ],
            'request_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'approval_one_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'approval_two_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'authenticator_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'rejected_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'need_revision_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'total_qty' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'total_item' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'total_price' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'invoice_dir' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('request_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('approval_one_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('approval_two_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('authenticator_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('rejected_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('need_revision_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('submissions');
    }

    public function down()
    {
        $this->forge->dropTable('submissions');
    }
}
