<?php

	class httpResponse {

		private static $single;         // Store instance of this class
		private $code = 200;            // Store http response code
		private $content = '';          // Store http response content
		private $headers = [];          // Store http response headers
		private $codeIsSent = false;    // Track if code sent
		private $contentIsSent = false; // Track if content sent
		private $headersIsSent = false; // Track if headers sent

		// Initialse singleton
		public static function init() {

			if(self::$single) return self::$single;
			else return self::$single = new static;

		}

		// Set the http response code
		public function setCode($code) { $this->code = (int)$code; return $this; }

		// Set the http response content
		public function setContent($content, $append = false) {

			if($append) $this->content = $this->getContent() . (string)$content;
			else $this->content = (string)$content;
			return $this;

		}

		// Set a http response header
		public function setHeader($header, $value) {

			$this->headers[(string)$header] = $value;
			return $this;

		}

		// Set http response headers with array`
		public function setHeadersArray(array $headers) {

			foreach($headers as $header => $value) $this->setHeader($header, $value);
			return $this;

		}

		// Set http response code sent flag
		private function setCodeIsSent() {

			$this->codeIsSent = true;
			return $this;

		}

		// Set http response content sent flag
		private function setContentIsSent() {

			$this->contentIsSent = true;
			return $this;

		}

		// Set http response headers sent flag
		private function setHeadersIsSent() {

			$this->headersIsSent = true;
			return $this;

		}

		// Return http response code
		public function getCode() { return $this->code; }

		// Return http response content
		public function getContent() { return $this->content; }

		// Return an http response header
		public function getHeader($header, $default = NULL) {

			if(in_array((string)$header, array_keys($this->headers))) {
				return $this->headers[(string)$header];
			} else return $default;

		}

		// Return http response headers as array
		public function getHeadersArray() { return $this->headers; }

		// Return code is sent flag
		public function getCodeIsSent() { return $this->codeIsSent; }

		// Return content is sent flag
		public function getContentIsSent() { return $this->contentIsSent; }

		// Return headers is sent flag
		public function getHeadersIsSent() { return $this->headersIsSent; }

		// Return http response message determined by response code
		public function getMessage() {

			switch($this->getCode()) {
				case 100: return 'Continue';
				case 101: return 'Switching Protocols';
				case 102: return 'Processing';
				case 200: return 'OK';
				case 201: return 'Created';
				case 202: return 'Accepted';
				case 203: return 'Non-Authoritative Information';
				case 204: return 'No Content';
				case 205: return 'Reset Content';
				case 206: return 'Partial Content';
				case 207: return 'Multi-Status';
				case 208: return 'Already Reported';
				case 226: return 'IM Used';
				case 300: return 'Multiple Choices';
				case 301: return 'Moved Permanently';
				case 302: return 'Found';
				case 303: return 'See Other';
				case 304: return 'Not Modified';
				case 305: return 'Use Proxy';
				case 306: return 'Switch Proxy';
				case 307: return 'Temporary Redirect';
				case 308: return 'Permanent Redirect';
				case 400: return 'Bad Request';
				case 401: return 'Unauthorized';
				case 402: return 'Payment Required';
				case 403: return 'Forbidden';
				case 404: return 'Not Found';
				case 405: return 'Method Not Allowed';
				case 406: return 'Not Acceptable';
				case 407: return 'Proxy Authentication Required';
				case 408: return 'Request Timeout';
				case 409: return 'Conflict';
				case 410: return 'Gone';
				case 411: return 'Length Required';
				case 412: return 'Precondition Failed';
				case 413: return 'Request Entity Too Large';
				case 414: return 'Request-URI Too Long';
				case 415: return 'Unsupported Media Type';
				case 416: return 'Requested Range Not Satisfiable';
				case 417: return 'Expectation Failed';
				case 418: return 'I\'m a teapot';
				case 419: return 'Authentication Timeout';
				case 420: return 'Enhance Your Calm';
				case 420: return 'Method Failure';
				case 422: return 'Unprocessable Entity';
				case 423: return 'Locked';
				case 424: return 'Failed Dependency';
				case 424: return 'Method Failure';
				case 425: return 'Unordered Collection';
				case 426: return 'Upgrade Required';
				case 428: return 'Precondition Required';
				case 429: return 'Too Many Requests';
				case 431: return 'Request Header Fields Too Large';
				case 444: return 'No Response';
				case 449: return 'Retry With';
				case 450: return 'Blocked by Windows Parental Controls';
				case 451: return 'Redirect';
				case 451: return 'Unavailable For Legal Reasons';
				case 494: return 'Request Header Too Large';
				case 495: return 'Cert Error';
				case 496: return 'No Cert';
				case 497: return 'HTTP to HTTPS';
				case 499: return 'Client Closed Request';
				case 500: return 'Internal Server Error';
				case 501: return 'Not Implemented';
				case 502: return 'Bad Gateway';
				case 503: return 'Service Unavailable';
				case 504: return 'Gateway Timeout';
				case 506: return 'Variant Also Negotiates';
				case 507: return 'Insufficient Storage';
				case 508: return 'Loop Detected';
				case 509: return 'Bandwidth Limit Exceeded';
				case 510: return 'Not Extended';
				case 511: return 'Network Authentication Required';
				case 598: return 'Network read timeout error';
				case 599: return 'Network connect timeout error';
				default: return 'Unknown Response';
			}

		}

		// Unset a http response header
		public function unsetHeader($key) {

			unset($this->headers[(string)$key]);
			return $this;

		}

		// Unset http response headers array
		public function unsetHeadersArray() {

			$this->headers = [];
			return $this;

		}

		// Send http response code to client
		public function sendCode() {

			if($this->getCodeIsSent()) {
				trigger_error(
					'http response code already sent, sending again',
					E_USER_WARNING
				);
			}
			$protocol = httpRequest::init()->getServerValue('SERVER_PROTOCOL', 'HTTP/1.0');
			header($protocol . ' ' . $this->getCode() . ' ' . $this->getMessage());
			$this->setCodeIsSent();
			return $this;

		}

		// Send http response content to client
		public function sendContent() {

			if($this->getContentIsSent()) {
				trigger_error(
					'http response content already sent, sending again',
					E_USER_WARNING
				);
			}
			echo $this->getContent();
			$this->setContentIsSent();
			return $this;

		}

		// Send http response  headers to client
		public function sendHeaders() {

			if($this->getHeadersIsSent()) {
				trigger_error(
					'http response headers already sent, sending again',
					E_USER_WARNING
				);
			}
			foreach($this->getHeadersArray() as $header => $value) {
				header($header . ': ' . (string)$value);
			}
			$this->setHeadersIsSent();
			return $this;

		}

		// Send http response code, content and headers to client
		public function sendAll() {

			$this->sendCode()
				->sendHeaders()
				->sendContent();
			return $this;

		}

	}
