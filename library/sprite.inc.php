<?php

	class sprite {

		private $name;
		private $controllerClass;
		private $controllerFilepath;
		private $modelClass;
		private $modelFilepath;
		private $viewFilepath;

		private function __construct($name) {

			$this->initName($name)
				->initControllerClass($name)
				->initControllerFilepath($name)
				->initModelClass($name)
				->initModelFilepath($name)
				->initViewFilepath($name)
				->render();

		}

		public static function __callStatic($name, $args) {

			$self = new static($name);

		}

		private function initName($name) {

			$this->name = (string)$name;
			return $this;

		}

		private function initControllerClass($name) {

			$this->controllerClass = (string)$name . 'SpriteController';
			return $this;

		}

		private function initControllerFilepath($name) {

			$this->controllerFilepath = DR . 'sprites' . DS
				. (string)$name . DS . 'controller.php';
			return $this;

		}

		private function initModelClass($name) {

			$this->modelClass = (string)$name . 'SpriteModel';
			return $this;

		}

		private function initModelFilepath($name) {

			$this->modelFilepath = DR . 'sprites' . DS
				. (string)$name . DS . 'model.php';
			return $this;

		}

		private function initViewFilepath($name) {

			$this->viewFilepath = DR . 'sprites' . DS
				. (string)$name . DS . 'view.php';
			return $this;

		}

		private function render() {

			if(!is_file($this->getControllerFilepath())) {
				trigger_error(
					'file ' . $this->getControllerFilepath() . ' no found',
					E_USER_WARNING
				);
			} else {
				include($this->controllerFilepath());
				$controllerClass = $this->getControllerClass();
				if(!class_exists($controllerClass)) {
					trigger_error(
						'class ' . $controllerClass . ' no found',
						E_USER_WARNING
					);
				} elseif(!method_exists('sprite')) {
					trigger_error(
						'required method sprite not found in ' . $controllerClass,
						E_USER_WARNING
					);
				} elseif(!is_file($this->getModelFilepath())) {
					trigger_error(
						'file ' . $this->getModelFilepath() . ' not found',
						E_USER_WARNING
					);
				} else {
					include($this->getModelFilepath());
					$modelClass = $this->getModelClass();
					if(!class_exists($modelClass)) {
						trigger_error(
							'class ' . $modelClass . ' not found',
							E_USER_WARNING
						);
					} elseif(!is_file($this->getViewFilepath())) {
						trigger_error(
							'file ' . $this->getViewFilepath() . ' not found',
							E_USER_WARNING
						);
					} else {
						$model = new $modelClass;
						$controller = new $controllerClass;
						$controller->model = $model;
						$controller->sprite();
						include($this->getViewFilepath());
					}
				}
			}
			return $this;

		}

	}
