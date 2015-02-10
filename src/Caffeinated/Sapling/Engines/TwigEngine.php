<?php
namespace Caffeinated\Sapling\Engines;

use Illuminate\View\Engines\EngineInterface;
use Twig_Environment;

class TwigEngine implements EngineInterface
{
	/**
	 * Create a new instance of the Twig engine.
	 *
	 * @param  Twig_Envrionment $twig
	 * @return void
	 */
	public function __construct(Twig_Environment $twig)
	{
		$this->twig = $twig;
	}

	/**
	 * Get the evaluated contents of the view.
	 *
	 * @param  string  $path
	 * @param  array   $data
	 * @return string
	 */
	public function get($path, array $data = array())
	{
		$paths = $this->twig->getLoader()->getPaths();

		foreach ($paths as $searchPath) {
			if (strpos($path, $searchPath) !== false) {
				$path = substr($path, strlen($searchPath));

				break;
			}
		}

		return $this->twig->loadTemplate($path)->render($data);
	}
}