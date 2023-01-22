<?php

return
[
    'types' =>
    [
        'unknown' => 0,
        'create' =>
        [
            'task' => 1,
        ],
        'modify' =>
        [
            'action' =>
            [
                'do' =>
                [
                    'status' => 2,
                    'importance' => 3,
                    'immediate' => 4,
                ],
                'transfer' => 5,
                'reject' => 6,
            ],
            'integrate' =>
            [
                'old' => 7,
                'new' => 8,
            ],
        ],
        'delete' =>
        [

        ],
    ],
];