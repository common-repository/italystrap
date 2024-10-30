<?php
declare(strict_types=1);

namespace ItalyStrap\Empress;

use Auryn\ConfigException;
use Auryn\InjectionException;
use ItalyStrap\Config\ConfigInterface as Config;
use function array_walk;
use function is_int;

/**
 * AurynResolver
 * Class Application
 * @package ItalyStrap\Empress
 */
class AurynResolver implements AurynResolverInterface {

	const PROXY = 'proxies';
	const SHARING = 'sharing';
	const ALIASES = 'aliases';
	const DEFINITIONS = 'definitions';
	const DEFINE_PARAM = 'define_param';
	const DELEGATIONS = 'delegations';
	const PREPARATIONS = 'preparations';

	private const METHODS = [
		self::PROXY			=> 'proxy',
		self::SHARING		=> 'share',
		self::ALIASES		=> 'alias',
		self::DEFINITIONS	=> 'define',
		self::DEFINE_PARAM	=> 'defineParam',
		self::DELEGATIONS	=> 'delegate',
		self::PREPARATIONS	=> 'prepare',
	];

	/**
	 * @var Injector
	 */
	private $injector;
	/**
	 * @var Config
	 */
	private $dependencies;

	/**
	 * @var array<Extension>
	 */
	private $extensions = [];

	/**
	 * Application constructor.
	 * @param Config $dependencies
	 * @param Injector $injector
	 */
	public function __construct( Injector $injector, Config $dependencies ) {
		$this->injector = $injector;
		$this->dependencies = $dependencies;
	}

	/**
	 * @inheritDoc
	 */
	public function resolve(): void {

		/**
		 * @var string $key
		 * @var callable $method
		 */
		foreach ( self::METHODS as $key => $method ) {
			$this->walk( $key, [ $this, $method ] );
		}

		/** @var Extension $extension */
		foreach ( $this->extensions as $extension ) {
			$extension->execute( $this );
		}
	}

	/**
	 * @inheritDoc
	 */
	public function extend( Extension ...$extensions ): void {
		foreach ( $extensions as $extension ) {
			$this->extensions[ $extension->name() ] = $extension;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function walk( string $key, callable $callback ): void {
		$dependencies = $this->dependencies->get( $key, [] );
		array_walk( $dependencies, $callback, $this->injector );
	}

	/**
	 * @param mixed $nameOrInstance
	 * @param int $index
	 * @throws ConfigException
	 */
	protected function share( $nameOrInstance, $index ): void {

		$this->assertIndexIsCorrectType(
			$index,
			__METHOD__,
			Injector::E_SHARE_ARGUMENT
		);

		$this->injector->share( $nameOrInstance );
	}

	/**
	 * @param string $name
	 * @param int $index
	 * @throws ConfigException
	 */
	protected function proxy( string $name, $index ): void {

		$this->assertIndexIsCorrectType(
			$index,
			__METHOD__,
			Injector::E_PROXY_ARGUMENT
		);

		$this->injector->proxy( $name );
	}

	/**
	 * @param string $implementation
	 * @param string $interface
	 * @throws ConfigException
	 */
	protected function alias( string $implementation, string $interface ): void {
		$this->injector->alias( $interface, $implementation );
	}

	/**
	 * @param array $class_args
	 * @param string $class_name
	 */
	protected function define( array $class_args, string $class_name ): void {
		$this->injector->define( $class_name, $class_args );
	}

	/**
	 * @param mixed $param_args
	 * @param string $param_name
	 */
	protected function defineParam( $param_args, string $param_name ): void {
		$this->injector->defineParam( $param_name, $param_args );
	}

	/**
	 * @param string $callableOrMethodStr
	 * @param string $name
	 * @throws ConfigException
	 */
	protected function delegate( $callableOrMethodStr, string $name ): void {
		$this->injector->delegate( $name, $callableOrMethodStr );
	}

	/**
	 * @param mixed $callableOrMethodStr
	 * @param string $name
	 * @throws InjectionException
	 */
	protected function prepare( $callableOrMethodStr, string $name ): void {
		$this->injector->prepare( $name, $callableOrMethodStr );
	}

	/**
	 * @param mixed $index
	 * @param string $method
	 * @param int $error_code
	 * @throws ConfigException
	 */
	private function assertIndexIsCorrectType( $index, string $method, int $error_code ): void {
		if ( ! is_int( $index ) ) {
			throw new ConfigException(
				sprintf(
					'%s() config does not have $key => $value pair, only $value',
					$method
				),
				$error_code
			);
		}
	}
}
