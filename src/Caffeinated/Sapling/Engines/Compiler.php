<?php
namespace Caffeinated\Sapling\Engines;

use Caffeinated\Sapling\Twig\Template;
use Exception;
use Illuminate\View\Compilers\CompilerInterface;
use InvalidArgumentException;
use Twig_Environment;
use Twig_Error_Loader;

class Compiler implements CompilerInterface
{
	protected $twig;

	public function __construct(Twig_Environment $twig)
	{
		$this->twig = $twig;
	}

	public function getTwig()
	{
		return $this->twig;
	}

	public function getCompiledPath($path)
	{
		return $this->twig->getCacheFilename($path);
	}

	public function isExpired($path)
	{
		$time = filemtime($this->getCompiledPath($path));

		return $this->twig->isTemplateFresh($path, $time);
	}

	public function compile($path)
	{
		try {
			$this->load($path);
		} catch (Exception $e) {
			// 
		}
	}

	public function load($path)
	{
		try {
			$template = $this->twig->loadTemplate($path);
		} catch (Twig_Error_Loader $e) {
			throw new InvalidArgumentException("Error in {$name}: ".$e->getMessage(), $e->getCode(), $e);
		}

		if ($template instanceof Template) {
			$template->setFiredEvents(true);
		}

		return $template;
	}
}