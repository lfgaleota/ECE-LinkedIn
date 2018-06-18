<?php

namespace App\Exceptions;


class QuotaExceededException extends \Exception {
	public function __construct($message = 'User quota has been exceeded', $code = 0, \Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}