<?php

	class httpRedirectException extends Exception {

		private $location;

		public function __construct($location) { $this->setLocation($location); }

		public function setLocation($location) {

			$this->location = (string)$location;
			return $this;

		}

		public function getLocation() { return $this->location; }

	}
