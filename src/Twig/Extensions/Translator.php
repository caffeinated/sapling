<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Illuminate\Translation\Translator as IlluminateTranslator;
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class Translator extends Twig_Extension
{
	/**
	 * @var \Illuminate\Translation\Translator
	 */
	protected $translator;

	/**
	 * Create a new Translator Twig_Extension instance.
	 *
	 * @param \Illuminate\Translation\Translator $translator
	 */
	public function __construct(IlluminateTranslator $translator)
	{
		$this->translator = $translator;
	}

	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_Translator';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('trans', [$this->translator, 'trans']),
			new Twig_SimpleFunction('trans_choice', [$this->translator, 'transChoice']),
		];
	}

	/**
	 * Returns a list of filters to add to the existing list.
	 *
	 * @return array An array of filters
	 */
	public function getFilters()
	{
		return [
			new Twig_SimpleFilter('trans', [$this->translator, 'trans'], [
				'pre_escape' => 'html', 'is_safe' => ['html']
			]),
			
			new Twig_SimpleFilter('trans_choice', [$this->translator, 'transChoice'], [
				'pre_escape' => 'html', 'is_safe' => ['html']
			]),
		];
	}
}