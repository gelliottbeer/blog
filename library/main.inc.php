<?php

	class main {

		public function __construct() {

			$function = AM;
			$this->$function();

		}

		private function web() {

			try {
				$response = httpResponse::init();
			}
			catch(httpMissingException $missingException) {
				$response->unsetHeadersArray()
					->setCode(400)
					->setContent(NULL);
			}
			catch(httpRedirectException $redirectException) {
				$response->unsetHeadersArray()
					->setCode(303)
					->setContent(NULL)
					->setHeader('Location', $redirectException->getLocation())
			}
			$response->sendAll();

		}

	}
