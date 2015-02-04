<?php namespace Owlgrin\Guard\Exceptions;

class ForbiddenException extends Exception {

	/**
	 * Message
	 */
	const MESSAGE = 'guard::responses.message.forbidden';

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