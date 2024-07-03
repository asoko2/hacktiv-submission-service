<?php

namespace App\Controllers\API;

use CodeIgniter\HTTP\ResponseInterface;

class SubmissionItemController extends BaseController
{
    public function showItems($id)
    {
        $submissionModel = new \App\Models\SubmissionModel();
        $submissionItemModel = new \App\Models\SubmissionItemModel();

        $submission = $submissionModel->find($id);

        $data = $submissionItemModel->where('submission_id', $id)->orderBy('id', 'ASC')->findAll();

        $items = [];

        foreach ($data as $item) {
            $items[] = [
                'id' => $item['id'],
                'itemName' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'total' => $item['total_price'],
            ];
        }

        if ($data) {
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Data found',
                'data' => [
                    'submission' => $submission,
                    'items' => $items
                ]
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Data not found',
                'data' => new \stdClass
            ]);
        }
    }

    public function update($id = null)
    {
        $submissionItemModel = new \App\Models\SubmissionItemModel();

        $data = $this->request->getJSON();

        $item = $submissionItemModel->find($id);

        if ($item) {
            $submissionItemModel->update($id, $data);

            $submissionItem = $submissionItemModel->find($id);

            $this->updateSubmissionAfterUpdateItem($submissionItem['submission_id']);

            return $this->response->setJSON([
                'status' => 200,
                'error' => null,
                'message' => 'Data updated',
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 404,
                'error' => 'Data not found',
                'message' => 'Data not found',
                'data' => new \stdClass
            ]);
        }
    }

    function updateSubmissionAfterUpdateItem($submissionId)
    {
        $submissionItemModel = new \App\Models\SubmissionItemModel();
        $submissionModel = new \App\Models\SubmissionModel();

        $items = $submissionItemModel->where('submission_id', $submissionId)->findAll();

        $totalQty = 0;
        $totalItem = 0;
        $totalPrice = 0;

        foreach ($items as $item) {
            $totalQty += $item['qty'];
            $totalItem++;
            $totalPrice += $item['total_price'];
        }

        $submissionModel->update($submissionId, [
            'total_qty' => $totalQty,
            'total_item' => $totalItem,
            'total_price' => $totalPrice
        ]);
    }
}
