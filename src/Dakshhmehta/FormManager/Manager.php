<?php namespace Dakshhmehta\FormManager;

use View;
use Illuminate\Html\FormBuilder;
use Request;
use URL;
use Config;

class Manager {
	private $fields = array();
	private $forms = array();
	private $name;
	private $action;
	private $method;
	private $attributes = array();
	private static $builder;

	public function __construct($name = 'container', FormBuilder $builder){
		$this->name = $name;
		$this->action = URL::to(Request::path());
		$this->method = 'POST';
		self::$builder = $builder;
	}

	public function form($key = 'main'){
		if(! isset($this->forms[$key])){
			$this->forms[$key] = new Manager($key, self::$builder);
		}

		return $this->forms[$key];
	}

	public function setAction($action){
		$this->action = $action;

		return $this;
	}

	public function setMethod($method){
		$this->method = $method;

		return $this;
	}

	public function add($label, $name, $type, $value = null, $args = array()){
		$this->fields[$name] = array(
			'label' => $label,
			'type' => $type,
			'value' => $value,
			'args' => $args,
		);

		return $this;
	}

	public function render($template = 'form-manager::wrapper'){
		$form = $this->prepareForUI();
		$output = View::make($template)->with('form', $form);

		return $output;
	}

	private function prepareForUI(){
		$output = array();

		$output['name'] = $this->name;
		$output['action'] = $this->action;
		$output['method'] = $this->method;
		$output['forms'] = array();

		foreach($this->fields as $name => $field){
			$args = array($name, $field['value']);
			if(count($field['args']) > 0){
				$args = array_merge($args, $field['args']);
			}

			$output['fields'][$name] = $field;
			$output['fields'][$name]['html'] = call_user_func_array([self::$builder, $field['type']], $args);
		}

		// Add Child forms as well
		if(count($this->forms) > 0){
			foreach($this->forms as $form){
				$output['forms'][] = $form->prepareForUI();
			}
		}

		return $output;
	}
}