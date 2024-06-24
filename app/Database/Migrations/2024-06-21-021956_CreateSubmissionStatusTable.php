<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubmissionStatusTable extends Migration
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
            'status_code' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'status_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ]
        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('submission_status');
    }

    public function down()
    {
        $this->forge->dropTable('submission_status');
    }
}
