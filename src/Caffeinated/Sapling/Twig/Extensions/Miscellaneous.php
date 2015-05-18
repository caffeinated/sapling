<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Twig_Extension;
use Twig_SimpleFunction;

class Miscellaneous extends Twig_Extension
{
	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_Helpers';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('csrf_token', 'csrf_token'),
			new Twig_SimpleFunction('dd', 'dd', ['is_safe' => ['html']]),
			new Twig_SimpleFunction('elixir', 'elixir'),
		];
	}
}
