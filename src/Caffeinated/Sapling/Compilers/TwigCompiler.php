<?php
namespace Caffeinated\Sapling\Compilers;

use Exception;
use InvalidArgumentException;
use Twig_Environment;
use Twig_Error_Loader;
use Caffeinated\Sapling\Twig\Template;
use Illuminate\View\Compilers\CompilerInterface;

class TwigCompiler implements CompilerInterface
{
	/**
	 * @var \Twig_Environment
	 */
	protected $twig;

	/**
	 * Constructor.
	 *
	 * @param Twig_Environment $twig
	 */
	public function __construct(Twig_Environment $twig)
	{
		$this->twig = $twig;
	}

	/**
	 * Return the Twig instance.
	 *
	 * @return Twig_Environment
	 */
	public function getTwig()
	{
		return $this->twig;
	}

	/**
	 * Get the path to the compiled version of a view.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function getCompiledPath($path)
	{
		return $this->twig->getCacheFilename($path);
	}

	/**
	 * Determine if the given view is expired.
	 *
	 * @param  string  $path
	 * @return bool
	 */
	public function isExpired($path)
	{
		$time = filemtime($this->getCompiledPath($path));

		return $this->twig->isTemplateFresh($path, $time);
	}

	/**
	 * Compile the view at the given path.
	 *
	 * @param  string  $path
	 * @return void
	 */
	public function compile($path)
	{
		try {
			$this->load($path);
		} catch (Exception $e) {
			// 
		}
	}

	/**
	 * Load the given template.
	 *
	 * @param  string  $name
	 * @return Twig_TemplateInterface  A template instance representing the given template name
	 */
	public function load($name)
	{
		try {
			$template = $this->twig->loadTemplate($name);
		} catch (Twig_Error_Loader $e) {
			throw new InvalidArgumentException("Error in {$name}: ".$e->getMessage(), $e->getCode(), $e);
		}

		if ($template instanceof Template) {
			$template->setFiredEvents(true);
		}

		return $template;
	}
}