<?php
namespace Hamahang\LTM;
use Illuminate\Support\Facades\Facade;

class TASKFacade extends Facade
{
	protected static function getFacadeAccessor() {
		return 'TASK';
	}
}
