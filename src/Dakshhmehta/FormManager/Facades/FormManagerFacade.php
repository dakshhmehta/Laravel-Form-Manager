<?php namespace Dakshhmehta\FormManager\Facades;

use Illuminate\Support\Facades\Facade;

class FormManagerFacade extends Facade {
	protected static function getFacadeAccessor() { return 'form.manager'; }
}