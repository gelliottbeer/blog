<?php

	class controller {

		private $controllerClass;
		private $modelClass;
		private $method;
		private $viewFilepath;

		public function __call($controller, $args) {

			$this->__initControllerClass($controller)
				->__initModelClass($controller)
				->__initMethod($method)
				->__initViewFilepath($controller, $method);

		}

		private function __initControllerClass($controller) {

			$this->controllerClass = (string)$controller . 'Controller';
			return $this;

		}

		private function __initModelClass($controller) {

			$this->modelClass = (string)$controller . 'Model';
			return $this;

		}

		private function __initMethod($method) {

			$this->method = (string)$method;
			return $this;

		}

		private function __initViewFilepath($controller, $method) {

			$this->viewFilepath = DR . 'views' . DS
				. $controller . DS . $method . '.php';
			return $this;

		}

	}
