<?php

namespace Hamahang\LTM\Controllers\Clients\Tasks;

use Hamahang\LTM\Controllers\Controller;

class TaskLogController extends Controller
{
    /**
     * @var int
     */
    var $auth = 400;

    /**
     * TaskLogController constructor.
     */
    public function __construct()
    {
        //$this->auth = auth()->id();
    }
}
