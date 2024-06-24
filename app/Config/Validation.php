<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    public array $create_submission = [
        'year' => 'required|numeric',
        'semester' => 'required',
        'name' => 'required',
        'request_user_id' => 'required|numeric',
        'reason_rejected' => 'permit_empty',
        'status' => 'required|in_list[0,1,2,3,4,5,6,7]',
        'reason_need_revision' => 'permit_empty',
        'approval_one_user_id' => 'permit_empty|numeric',
        'approval_two_user_id' => 'permit_empty|numeric',
        'authenticator_user_id' => 'permit_empty|numeric',
        'rejected_user_id' => 'permit_empty|numeric',
        'need_revision_user_id' => 'permit_empty|numeric',
        'total_qty' => 'required|numeric',
        'total_item' => 'required|numeric',
        'total_price' => 'required|numeric',
        'invoice_dir' => 'permit_empty',
    ];

    public array $create_submission_error = [
        'year' => [
            'required' => 'Year field is required',
            'numeric' => 'Year field must be a number',
        ],
        'semester' => [
            'required' => 'Semester field is required',
            'numeric' => 'Semester field must be a number',
        ],
        'name' => [
            'required' => 'Name field is required',
            'string' => 'Name field must be a string',
        ],
        'request_user_id' => [
            'required' => 'Request User ID field is required',
            'numeric' => 'Request User ID field must be a number',
        ],
        'reason_rejected' => [
            'permit_empty' => 'Reason Rejected field must be a string',
        ],
        'status' => [
            'required' => 'Status field is required',
            'in_list' => 'Status field must be one of: pending_approval_one, pending_approval_two, pending_approval_authenticator, done, rejected, need_revision, wait_document',
        ],
        'reason_need_revision' => [
            'permit_empty' => 'Reason Need Revision field must be a string',
        ],
        'approval_one_user_id' => [
            'permit_empty' => 'Approval One User ID field must be a number',
            'numeric' => 'Approval One User ID field must be a number',
        ],
        'approval_two_user_id' => [
            'permit_empty' => 'Approval Two User ID field must be a number',
            'numeric' => 'Approval Two User ID field must be a number',
        ],
        'authenticator_user_id' => [
            'permit_empty' => 'Authenticator User ID field must be a number',
            'numeric' => 'Authenticator User ID field must be a number',
        ],
        'rejected_user_id' => [
            'permit_empty' => 'Rejected User ID field must be a number',
            'numeric' => 'Rejected User ID field must be a number',
        ],
        'need_revision_user_id' => [
            'permit_empty' => 'Need Revision User ID field must be a number',
            'numeric' => 'Need Revision User ID field must be a number',
        ],
        'total_qty' => [
            'required' => 'Total Qty field is required',
            'numeric' => 'Total Qty field must be a number',
        ],
        'total_item' => [
            'required' => 'Total Item field is required',
            'numeric' => 'Total Item field must be a number',
        ],
        'total_price' => [
            'required' => 'Total Price field is required',
            'numeric' => 'Total Price field must be a number',
        ],
        'invoice_dir' => [
            'permit_empty' => 'Invoice Dir field must be a string',
        ],
    ];

    public array $reject_submission = [
        'reason_rejected' => 'required',
        'rejected_user_id' => 'required|numeric',
    ];

    public array $reject_submission_error = [
        'reason_rejected' => [
            'required' => 'Reason Rejected field is required',
            'string' => 'Reason Rejected field must be a string',
        ],
        'rejected_user_id' => [
            'required' => 'Rejected User ID field is required',
            'numeric' => 'Rejected User ID field must be a number',
        ],
    ];

    public array $need_revision_submission = [
        'reason_need_revision' => 'required',
        'need_revision_user_id' => 'required|numeric',
    ];

    public array $need_revision_submission_error = [
        'reason_need_revision' => [
            'required' => 'Reason Need Revision field is required',
            'string' => 'Reason Need Revision field must be a string',
        ],
        'need_revision_user_id' => [
            'required' => 'Need Revision User ID field is required',
            'numeric' => 'Need Revision User ID field must be a number',
        ],
    ];

    public array $approval_atasan = [
        'approval_user_id' => 'required|numeric',
    ];

    public array $approval_atasan_error = [
        'approval_user_id' => [
            'required' => 'Approval User ID field is required',
            'numeric' => 'Approval User ID field must be a number',
        ],
    ];

    public array $approval_hrd = [
        'approval_user_id' => 'required|numeric',
    ];

    public array $approval_hrd_error = [
        'approval_user_id' => [
            'required' => 'Approval User ID field is required',
            'numeric' => 'Approval User ID field must be a number',
        ],
    ];

    public array $upload_invoice = [
        'invoice' => 'max_size[invoice,2048]|ext_in[invoice,pdf]',
    ];

    public array $upload_invoice_error = [
        'invoice' => [
            'max_size' => 'Invoice field must be less than 2MB',
            'ext_in' => 'Invoice field must be a PDF file',
        ],
    ];
}
