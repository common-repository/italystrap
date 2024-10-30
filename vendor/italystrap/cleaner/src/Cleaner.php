<?php
/**
 * @todo Sistemare lo schema per sanitizzare e validare i dati, di seguito alcune idee
 * L'ideale potrebbe essere quello di fornire lo schema nel costruttore ed opzionalmente nel metodo tipo `get($key, $schema)`
 * @todo https://packagist.org/?query=schema%20val
 * @todo https://github.com/balambasik/input
 * @todo https://github.com/j4s/validation
 * @todo https://github.com/j4s/superglobals/blob/develop/src/ValidateSuperglobalsOrNot.php
 *
 */
declare(strict_types=1);

namespace ItalyStrap\Cleaner;

class Cleaner {

	private $sanitizator;
	private $validator;

	public function __construct( SanitizableInterface $sanitizator, ValidableInterface $validator ) {
		$this->sanitizator = $sanitizator;
		$this->validator = $validator;
	}
}