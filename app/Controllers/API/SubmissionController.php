<?php

namespace App\Controllers\API;

use CodeIgniter\Files\File;
use CodeIgniter\HTTP\ResponseInterface;

class SubmissionController extends BaseController
{
    protected $validation;

    public function __construct()
    {
        $this->validation = service('validation');
    }

    public function index()
    {
        $model = new \App\Models\SubmissionModel();
        $data = $model->findAll();
        return $this->response->setJSON([
            'status' => 200,
            'error' => null,
            'message' => 'Data found',
            'data' => $data
        ]);
    }

    public function store()
    {
        $submissionModel = new \App\Models\SubmissionModel();
        $data = $this->request->getJSON();
        $this->validation->setRuleGroup('create_submission');

        if (!$this->validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $this->validation->getErrors(),
                'message' => 'Submission Request failed',
            ]);
        }

        try {
            $submissionModel->insert($data);
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Submission Request created',
            ]);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $submissionModel->errors(),
                'message' => 'Submission Request failed',
            ]);
        }
    }

    public function show($id = null)
    {
        try {
            $submissionModel = new \App\Models\SubmissionModel();

            $builder = $submissionModel->builder();

            $data = $builder
                ->select([
                    'submissions.*',
                    'submission_status.status_name as status_name',
                    'requester.name as request_user_name',
                    'approval_atasan.name as atasan_name',
                    'approval_hrd.name as hrd_name',
                    'authenticator.name as authenticator_name',
                    'need_revision.name as need_revision_name',
                    'rejector.name as rejector_name',
                ])
                ->join('submission_status', 'submission_status.id = submissions.status', 'left')
                ->join('users as requester', 'requester.id = submissions.request_user_id', 'left')
                ->join('users as approval_atasan', 'approval_atasan.id = submissions.approval_one_user_id', 'left')
                ->join('users as approval_hrd', 'approval_hrd.id = submissions.approval_two_user_id', 'left')
                ->join('users as authenticator', 'authenticator.id = submissions.authenticator_user_id', 'left')
                ->join('users as need_revision', 'need_revision.id = submissions.need_revision_user_id', 'left')
                ->join('users as rejector', 'rejector.id = submissions.rejected_user_id', 'left')
                ->where('submissions.id', $id)
                ->get()->getRow();

            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Data found',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $e->getMessage(),
                'message' => 'Data not found',
            ]);
        }
    }


    public function updateSubmission($id = null)
    {
        $submissionModel = new \App\Models\SubmissionModel();
        $data = $this->request->getJSON();
        $this->validation->setRuleGroup('create_submission');

        if (!$this->validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $this->validation->getErrors(),
                'message' => 'Update Submission Request failed',
            ]);
        }

        try {
            $submissionModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Update Submission Request success',
            ]);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $submissionModel->errors(),
                'message' => 'Update Submission Request failed',
            ]);
        }
    }

    public function approvalAtasan($id = null)
    {
        $submissionModel = new \App\Models\SubmissionModel();
        $input = $this->request->getJSON();

        $data = [
            'approval_one_user_id' => $input->approval_user_id,
            'status' => 2,
        ];

        $this->validation->setRuleGroup('approval_atasan');

        if (!$this->validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $this->validation->getErrors(),
                'message' => 'Approval Atasan failed',
            ]);
        }

        try {
            log_message('info', 'Data: ' . json_encode($data));
            $submissionModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Approval Atasan success',
            ]);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $submissionModel->errors(),
                'message' => 'Approval Atasan failed',
            ]);
        }
    }

    public function approvalHRD($id = null)
    {
        $submissionModel = new \App\Models\SubmissionModel();
        $input = $this->request->getJSON();

        $data = [
            'approval_two_user_id' => $input->approval_user_id,
            'status' => 3,
        ];

        $this->validation->setRuleGroup('approval_hrd');

        if (!$this->validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $this->validation->getErrors(),
                'message' => 'Approval HRD failed',
            ]);
        }

        try {
            $submissionModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Approval HRD success',
            ]);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $submissionModel->errors(),
                'message' => 'Approval HRD failed',
            ]);
        }
    }

    public function uploadInvoice($id = null)
    {
        $submissionModel = new \App\Models\SubmissionModel();
        $invoice = $this->request->getFile('invoice');

        if (!$invoice->isValid()) {
            $error = new \RuntimeException($invoice->getErrorString() . '(' . $invoice->getError() . ')');
            return $this->response->setJSON([
                'status' => 500,
                'error' => $error->getMessage(),
                'message' => 'Upload Invoice failed',
            ]);
        }

        $filepath = $invoice->store('invoice');
        log_message('debug', 'Filepath: ' . $filepath);

        $data = [
            'invoice_dir' => $filepath,
            'status' => 4,
        ];

        try {
            $submissionModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Upload Invoice success',
            ]);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $submissionModel->errors(),
                'message' => 'Upload Invoice failed',
            ]);
        }
    }

    public function approvalPengesah($id = null)
    {
        $submissionModel = new \App\Models\SubmissionModel();
        $input = $this->request->getJSON();

        $data = [
            'authenticator_user_id' => $input->approval_user_id,
            'status' => 5,
        ];

        try {
            $submissionModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Approval Authenticator success',
            ]);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $submissionModel->errors(),
                'message' => 'Approval Authenticator failed',
            ]);
        }
    }

    public function needRevision($id = null)
    {
        $submissionModel = new \App\Models\SubmissionModel();
        $input = $this->request->getJSON();

        $data = [
            'reason_need_revision' => $input->reason_need_revision,
            'need_revision_user_id' => $input->need_revision_user_id,
            'status' => 6,
        ];

        $this->validation->setRuleGroup('need_revision_submission');

        if (!$this->validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $this->validation->getErrors(),
                'message' => 'Need Revision failed',
            ]);
        }

        try {
            $submissionModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Need Revision success',
            ]);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $submissionModel->errors(),
                'message' => 'Need Revision failed',
            ]);
        }
    }

    public function reject($id = null)
    {
        $submissionModel = new \App\Models\SubmissionModel();
        $input = $this->request->getJSON();

        $data = [
            'reason_rejected' => $input->reason_rejected,
            'rejected_user_id' => $input->rejected_user_id,
            'status' => 7,
        ];

        $this->validation->setRuleGroup('reject_submission');

        if (!$this->validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $this->validation->getErrors(),
                'message' => 'Reject failed',
            ]);
        }

        try {
            $submissionModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Reject success',
            ]);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $submissionModel->errors(),
                'message' => 'Reject failed',
            ]);
        }
    }

    public function destroy($id = null)
    {
        try {
            $submissionModel = new \App\Models\SubmissionModel();
            $submissionModel->delete($id);
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Submission Request deleted',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $e->getMessage(),
                'message' => 'Submission Request failed',
            ]);
        }
    }
}
