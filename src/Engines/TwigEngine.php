<?php
namespace Caffeinated\Sapling\Engines;

use Caffeinated\Sapling\Compilers\TwigCompiler;
use Caffeinated\Sapling\Twig\Loader;
use Illuminate\View\Engines\CompilerEngine;
use ErrorException;
use Twig_Error;

class TwigEngine extends CompilerEngine
{
	/**
	 * @var array
	 */
	protected $globalData = [];

	/**
	 * @var array|\Caffeinated\Sapling\Twig\Loader
	 */
	protected $loader = [];

	/**
	 * Constructor.
	 *
	 * @param TwigCompiler  $compiler
	 * @param Loader        $loader
	 * @param array         $globalData
	 */
	public function __construct(TwigCompiler $compiler, Loader $loader, array $globalData = [])
	{
		parent::__construct($compiler);

		$this->loader     = $loader;
		$this->globalData = $globalData;
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
		$data = array_merge($this->globalData, $data);

		try {
			return $this->compiler->load($path)->render($data);
		} catch (Twig_Error $e) {
			$this->handleTwigError($e);
		}
	}

	/**
	 * Handle a thrown Twig_Error exception.
	 *
	 * @param  Twig_Error $e
	 * @return ErrorException
	 */
	protected function handleTwigError($e)
	{
		$templateFile = $e->getTemplateFile();
		$templateLine = $e->getTemplateLine();

		if ($templateFile and file_exists($templateFile)) {
			$file = $templateFile;
		} elseif ($templateFile) {
			$file = $this->loader->findTemplate($templateFile);
		}

		if (isset($file)) {
			$e = new ErrorException($e->getMessage(), 0, 1, $file, $templateLine, $e);
		}

		throw $e;
	}
}