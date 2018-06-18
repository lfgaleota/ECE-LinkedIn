<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler {
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $exception
	 *
	 * @return void
	 */
	public function report( Exception $exception ) {
		parent::report( $exception );
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception $exception
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function render( $request, Exception $exception ) {
		return parent::render( $request, $exception );
	}

	/**
	 * Render the given HttpException.
	 *
	 * @param  \Symfony\Component\HttpKernel\Exception\HttpException $e
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function renderHttpException( HttpException $e ) {
		if( $e->getStatusCode() === 500 && env( 'APP_DEBUG' ) === true ) {
			// Display Laravel's default error message with appropriate error information
			return $this->convertExceptionToResponse( $e );
		}

		return parent::renderHttpException( $e ); // Continue as normal
	}
}
