<?php
namespace Caffeinated\Sapling\Twig;

use Illuminate\Foundation\Application;
use InvalidArgumentException;
use Twig_Environment;
use Twig_Error;
use Twig_LoaderInterface;

class Environment extends Twig_Environment
{
	/**
	 * @var \Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * Constructor.
	 *
	 * @param Twig_LoaderInterface  $loader
	 * @param array                 $options
	 * @param Application           $app
	 */
	public function __construct(Twig_LoaderInterface $loader = null, $options = [], Application $app = null)
	{
		parent::__construct($loader, $options);

		$this->app = $app;
	}

	/**
	 * Loads a template by name.
	 *
	 * @param string  $name            The template name
	 * @param integer $index           The index if it is an embedded template
	 * @return Twig_TemplateInterface  A template instance representing the given template name
	 * @throws Twig_Error_Loader       When the template cannot be found
	 * @throws Twig_Error_Syntax       When an error occurred during compilation
	 */
	public function loadTemplate($name, $index = null)
	{
		$template = parent::loadTemplate($name, $index);

		return $template;
	}

	/**
	 * Merges a context with the defined shares.
	 *
	 * @param  array $context  An array representing the context
	 * @return array           The context merged with the shares
	 */
	public function mergeShared(array $context)
	{
		foreach ($this->app['view']->getShared() as $key => $value) {
			if (! array_key_exists($key, $context)) {
				$context[$key] = $value;
			}
		}

		return $context;
	}

	/**
	 * Gets the normalized filename for a given template.
	 *
	 * @param  string $name  The template name
	 * @return string        The normalized filename
	 */
	protected function normalizeName($name)
	{
		$extension = '.'.$this->app['sapling.twig.fileextension'];
		$length    = strlen($extension);

		if (substr($name, -$length, $length) === $extension) {
			$name = substr($name, 0, -$length);
		}

		return $name;
	}
}