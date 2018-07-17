<?php

	class main {

		public function __construct() {

			$function = AM;
			$this->$function();

		}

		private function web() {

			try {
				$response = httpResponse::init();
				$controller = httpRoute::init()->getController();
				$method = httpRoute::init()->getMethod();
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
			catch(httpAuthenticationException $authenticationException) {
				$response->unsetHeadersArray()
					->setContent(NULL);
				$location = $authenticationException->getLocation();
				if($location) {
					$response->setCode(303)
						->setHeader('Location', $location);
				} else $response->setCode(403);
			}
			catch(httpAuthorizationException $authorizationException) {
				$response->unsetHeadersArray()
					->setCode(403)
					->setContent(NULL);
			}
			$response->sendAll();

		}

	}
