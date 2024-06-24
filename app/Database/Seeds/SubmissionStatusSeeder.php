<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SubmissionStatusSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'status_code' => 'pending_approval_one', 'status_name' => 'Pending Approval One'],
            ['id' => 2, 'status_code' => 'pending_approval_two', 'status_name' => 'Pending Approval Two'],
            ['id' => 3, 'status_code' => 'wait_document', 'status_name' => 'Wait Document'],
            ['id' => 4, 'status_code' => 'pending_approval_authenticator', 'status_name' => 'Pending Approval Authenticator'],
            ['id' => 5, 'status_code' => 'done', 'status_name' => 'Done'],
            ['id' => 6, 'status_code' => 'need_revision', 'status_name' => 'Need Revision'],
            ['id' => 7, 'status_code' => 'rejected', 'status_name' => 'Rejected'],
        ];

        $this->db->table('submission_status')->insertBatch($data);
    }
}
