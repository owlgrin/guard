<?php namespace Owlgrin\Guard\Exceptions;

use Illuminate\Support\MessageBag;

class InvalidInputException extends Exception {

	/**
	 * Message
	 */
	const MESSAGE = 'guard::responses.message.invalid_input';

	/**
	 * Constructor
	 * @param mixed $messages
	 * @param array $replacers
	 */
	public function __construct($messages = self::MESSAGE, $replacers = array())
	{
		parent::__construct($messages, $replacers);
	}
}