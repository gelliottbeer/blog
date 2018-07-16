<?php

	class httpRoute {

		private static $single;
		private $controller = 'index';
		private $method = 'index';

		public static function init() {

			if(self::$single) return self::$single;
			else return self::$single = new static;

		}

		private function __construct() {

			$this->initController()
				->initMethod();

		}

		private function setController($controller) {

			$this->controller = (string)$controller;
			return $this;

		}

		private function setMethod($method) {

			$this->method = (string)$method;
			return $this;

		}

		public function getController() { return $this->controller; }
		public function getMethod() { return $this->method; }

		public function initController() {

			$uri = httpRequest::init()->getQueryValue('uri', '');
			$controller = current(explode('/', $uri));
			if($controller) $this->setController($controller);
			return $this;

		}

		public function initMethod() {

			$uri = httpRequest::init()->getQueryValue('uri', '');
			$method = @explode('/', $uri)[1];
			if($method) $this->setMethod($method);
			return $this;

		}

	}
