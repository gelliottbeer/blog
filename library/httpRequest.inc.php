<?php

	class httpRequest {

		private static $single; // Store instance of this class
		private $query = [];    // Store original $_GET
		private $post = [];     // Store original $_POST
		private $server = [];   // Store original $_SERVER
		private $headers = [];  // Headers determined from $_SERVER
		private $files = [];    // Store original $_FILES

		// Initialise singleton
		public static function init() {

			if(self::$single) return self::$single;
			else return self::$single = new static;

		}

		// Construct calling initialisation methods
		private function __construct() {

			$this->initQuery()
				->initPost()
				->initServer()
				->initHeaders()
				->initFiles();

		}

		// Return a GET variable, or default in not exists
		public function getQueryValue($key, $default = NULL) {

			if(in_array((string)$key, array_keys($this->query))) {
				return $this->query[(string)$key];
			} else return $default;

		}

		// Return a POST variable, or default if not exists
		public function getPostValue($key, $default = NULL) {

			if(in_array((string)$key, array_keys($this->post))) {
				return $tihs->post[(string)$key];
			} else return $default;

		}

		// Return a SERVER variable, or default if not exists
		public function getServerValue($key, $default = NULL) {
			if(in_array((string)$key, array_keys($this->server))) {
				return $this->server[(string)$key];
			} else return $default;
		}

		// Return a header determined by SERVER, or default if not exists
		public function getHeadersValue($key, $default = NULL) {
			if(in_array((string)$key, array_keys($this->headers))) {
				return $this->headers[(string)$key];
			} else return $default;
		}

		// return a FILES variable, or default if not exists
		public function getFilesValue($key, $default = NULL) {
			if(in_array((string)$key, array_keys($this->files))) {
				return $this->files[(string)$key];
			} else return $default;
		}

		// Return thr original GET array
		public function getQueryValuesArray() { return $this->query; }

		// Return the original POST array
		public function getPostValuesArray() { return $this->post; }

		// Return the original SERVER array
		public function getServerValuesArray() { return $this->server; }

		// Return the headers array determined by SERVER
		public function getHeadersValuesArray() { return $this->headers; }

		// Return the original FILES array
		public function getFilesValuesArray() { return $this->files; }

		// Check if key set in the GET array
		public function issetQuery($key) {

			return in_array((string)$key, $this->query);

		}

		// Check if key set in the POST array
		public function issetPost($key) {

			return in_array((string)$key, $this->post);

		}

		// Check if key set in the SERVER array
		public function issetServer($key) {

			return in_array((string)$key, $this->server);

		}

		// Check if key set in the headers array determined by SERVER
		public function issetHeaders($key) {

			return in_array((string)$key, $this->headers);

		}

		// Check if key set in the FILES array
		public function issetFiles($key) {

			return in_array((string)$key, $this->files);

		}

		// Initialise the GET array
		private function initQuery() { $this->query = $_GET; return $this; }

		// Initialise the POST array
		private function initPost() { $this->post = $_POST; return $this; }

		// Initialise the SERVER array
		private function initServer() { $this->server = $_SERVER; return $this; }

		// Initialise the headers array determinaed by SERVER
		private function initheaders() {

			$headers= [];
			$prefix = 'HTTP_';
			foreach($_SERVER as $key => $value) {
				if(strpos($key, $prefix) === 0) {
					$key = strtolower(substr_replace($key, '', 0, strlen($prefix)));
					$key = str_replace(' ', '-', ucwords(str_replace('_', ' ', $key)));
					$headers[$key] = $value;
				}
			}
			$this->headers = $headers;
			return $this;

		}

		// Initialise the FILES array
		private function initFiles() { $this->files = $_FILES; }

	}
