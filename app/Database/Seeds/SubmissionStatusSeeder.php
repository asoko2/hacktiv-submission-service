<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SubmissionStatusSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'status_code' => 'pending_approval_one', 'status_name' => 'Pending Approval Atasan'],
            ['id' => 2, 'status_code' => 'pending_approval_two', 'status_name' => 'Pending Approval HRD'],
            ['id' => 3, 'status_code' => 'wait_document', 'status_name' => 'Menunggu Invoice'],
            ['id' => 4, 'status_code' => 'pending_approval_authenticator', 'status_name' => 'Pending Approval Pengesah'],
            ['id' => 5, 'status_code' => 'done', 'status_name' => 'Selesai'],
            ['id' => 6, 'status_code' => 'need_revision', 'status_name' => 'Perlu Revisi'],
            ['id' => 7, 'status_code' => 'rejected', 'status_name' => 'Ditolak'],
        ];

        $this->db->table('submission_status')->insertBatch($data);
    }
}
