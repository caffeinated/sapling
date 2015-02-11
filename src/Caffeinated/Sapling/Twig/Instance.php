<?php
namespace Caffeinated\Sapling\Twig;

use Illuminate\Foundation\Application;
use InvalidArgumentException;
use Twig_Environment;
use Twig_Error;
use Twig_LoaderInterface;

class Instance extends Twig_Environment
{
	protected $app;

	public function __construct(Twig_LoaderInterface $loader = null, $options = [], Application $app = null)
	{
		parent::__construct($loader, $options);

		$this->app = $app;
	}

	public function loadTemplate($name, $index = null)
	{
		$template = parent::loadTemplate($name, $index);

		// $template->setName($this->normalizeName($name));

		return $template;
	}

	public function mergeShared(array $context)
	{
		foreach ($this->app['view']->getShared() as $key => $value) {
			if (! array_key_exists($key, $context)) {
				$context[$key] = $value;
			}
		}

		return $context;
	}

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