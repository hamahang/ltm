<?php

return
[
    1 =>
    [
        'title' =>
        [
            'text' => 'ایجاد وظیفه',
            'values' => [],
        ],
        'description' =>
        [
            'text' => 'این وظیفه توسط <b>[assigner]</b> برای <b>[employee]</b> ایجاد شد.<br /> [transcripts]',
            'values' =>
            [
                'assigner' => 'create_task_assigner',
                'employee' => 'create_task_employee',
                'transcripts' => 'create_task_transcripts',
            ],
        ],
    ],
    2 =>
    [
        'title' =>
        [
            'text' => 'تغییر وضعیت',
            'values' => [],
        ],
        'description' =>
        [
            'text' => 'وضعیت توسط <b>[by]</b> از <b>[old][old_percent]</b> به <b>[new][new_percent]</b> تغییر یافت.',
            'values' =>
            [
                'old' => 'modify_action_do_status_old',
                'old_percent' => 'modify_action_do_status_old_percent',
                'new' => 'modify_action_do_status_new',
                'new_percent' => 'modify_action_do_status_new_percent',
                'by' => 'modify_action_do_status_by',
            ],
        ],
    ],
    3 =>
    [
        'title' =>
        [
            'text' => 'تغییر اهمیت',
            'values' => [],
        ],
        'description' =>
        [
            'text' => 'اهمیت توسط <b>[by]</b> از <b>[old]</b> به <b>[new]</b> تغییر یافت.',
            'values' =>
            [
                'old' => 'modify_action_do_importance_old',
                'new' => 'modify_action_do_importance_new',
                'by' => 'modify_action_do_importance_by',
            ],
        ],
    ],
    4 =>
    [
        'title' =>
        [
            'text' => 'تغییر فوریت',
            'values' => [],
        ],
        'description' =>
        [
            'text' => 'فوریت توسط <b>[by]</b> از <b>[old]</b> به <b>[new]</b> تغییر یافت.',
            'values' =>
            [
                'old' => 'modify_action_do_immediate_old',
                'new' => 'modify_action_do_immediate_new',
                'by' => 'modify_action_do_immediate_by',
            ],
        ],
    ],
    5 =>
    [
        'title' =>
        [
            'text' => 'انتقال وظیفه',
            'values' => [],
        ],
        'description' =>
        [
            'text' => 'وظیفه توسط <b>[transmitter]</b> از <b>[from]</b> به <b>[to]</b> انتقال یافت.<br /> [transcripts]',
            'values' =>
            [
                'transmitter' => 'modify_action_transfer_transmitter',
                'from' => 'modify_action_transfer_from',
                'to' => 'modify_action_transfer_to',
                'transcripts' => 'modify_action_transfer_transcripts',
            ],
        ],
    ],
    6 =>
    [
        'title' =>
        [
            'text' => 'نپذیرفتن وظیفه',
            'values' => [],
        ],
        'description' =>
        [
            'text' => 'وظیفه توسط <b>[by]</b> پذیرفته نشد.',
            'values' =>
            [
                'by' => 'modify_action_transfer_by',
                'reason' => 'modify_action_transfer_reason',
            ],
        ],
    ],
    7 =>
    [
        'title' =>
        [
            'text' => 'ادغام وظایف',
            'values' => [],
        ],
        'description' =>
        [
            'text' => 'این وظیفه با <b>[task_ids]</b> توسط <b>[assigner]</b> ادغام و با عنوان <b>[task_id]</b> برای <b>[employee]</b> ایجاد شده است.',
            'values' =>
            [
                'task_ids' => 'modify_integrate_old_task_ids',
                'assigner' => 'modify_integrate_old_assigner',
                'task_id' => 'modify_integrate_old_task_id',
                'employee' => 'modify_integrate_old_employee',
            ],
        ],
    ],
    8 =>
    [
        'title' =>
        [
            'text' => 'ادغام وظایف',
            'values' => [],
        ],
        'description' =>
        [
            'text' => 'وظایف <b>[task_ids]</b> توسط <b>[assigner]</b> ادغام و با عنوان <b>[task_id]</b> برای <b>[employee]</b> به عنوان وظیفه جدید ایجاد شد.',
            'values' =>
            [
                'task_ids' => 'modify_integrate_new_task_ids',
                'assigner' => 'modify_integrate_new_assigner',
                'task_id' => 'modify_integrate_new_task_id',
                'employee' => 'modify_integrate_new_employee',
            ],
        ],
    ],
];
