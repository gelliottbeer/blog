<?php

	class controller {

		private $controllerClass;
		private $controllerFilepath;
		private $modelClass;
		private $modelFilepath;
		private $method;
		private $viewFilepath;

		public function __construct($controller, $method) {

			$this->initControllerClass($controller)
				->initModelClass($controller)
				->initMethod($method)
				->initViewFilepath($controller, $method)
				->initControllerFilepath($controller)
				->initModelFilepath($controller)
				->render();

		}

		public function getControllerClass() { return $this->controllerClass; }
		public function getModelClass() { return $this->modelClass; }
		public function getMethod() { return $this->method; }
		public function getViewFilepath() { return $this->viewFilepath; }
		public function getControllerFilepath() { return $this->controllerFilepath; }
		public function getModelFilepath() { return $this->modelFilepath; }

		public static function __callStatic($controller, $args) {

			$method = @$args[0];
			$self = new static($controller, $method);
			return $self;

		}

		private function initControllerClass($controller) {

			$this->controllerClass = (string)$controller . 'Controller';
			return $this;

		}

		private function initModelClass($controller) {

			$this->modelClass = (string)$controller . 'Model';
			return $this;

		}

		private function initMethod($method) {

			$this->method = (string)$method;
			return $this;

		}

		private function initViewFilepath($controller, $method) {

			$this->viewFilepath = DR . 'views' . DS
				. $controller . DS . $method . '.php';
			return $this;

		}

		private function initControllerFilepath($controller) {

			$this->controllerFilepath = DR . 'controllers' . DS
				. (string)$controller . '.php';
			return $this;

		}

		private function initModelFilepath($controller) {

			$this->modelFilepath = DR . 'models' . DS
				. (string)$controller . '.php';
			return $this;

		}

		private function render() {

			if(!is_file($this->getControllerFilepath())) {
				throw new httpMissingException;
			} else {
				include($this->getControllerFilepath());
				$controllerClass = $this->getControllerClass();
				if(!class_exists($controllerClass)) {
					trigger_error(
						'class ' . $controllerClass . ' not found',
						E_USER_WARNING
					);
					throw new httpMissingException;
				} elseif(!method_exists($controllerClass, $this->getMethod())) {
					throw new httpMissingException;
				} else {
					if(!is_file($this->getModelFilepath())) {
						trigger_error(
							'file ' . $this->getModelFilepath() . ' not found',
							E_USER_WARNING
						);
						throw new httpMissingException;
					} else {
						include($this->getModelFilepath());
						$modelClass = $this->getModelClass();
						if(!class_exists($modelClass)) {
							trigger_error(
								'class ' . $modelClass . ' not found',
								E_USER_WARNING
							);
							throw new httpMissingException;
						} elseif(!is_file($this->getViewFilepath())) {
							trigger_error(
								'file ' . $this->getViewFilepath(),
								E_USER_WARNING
							);
							throw new httpMissingException;
						} else {
							$model = new $modelClass;
							$controller = new $controllerClass;
							$controller->model = $model;
							include($this->getViewFilepath());
						}
					}
				}
			}
			return $this;

		}

	}
