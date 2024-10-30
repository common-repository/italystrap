<?php

declare(strict_types=1);

namespace ItalyStrap\Cleaner;

class CleanerFactory
{
	private $instance = [];

	public function make( string $type ) {
		if ( empty( $this->instance[ $type ] ) ) {
			$this->instance[ $type ] = new $type;
		}

		return $this->instance[ $type ];
	}
}