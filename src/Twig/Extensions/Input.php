<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Illuminate\Http\Request;
use Twig_Extension;
use Twig_SimpleFunction;

class Input extends Twig_Extension
{
	/**
	 * @var \Illuminate\Http\Request
	 */
	protected $request;

	/**
	 * Create a new Input Twig_Extension instance.
	 *
	 * @param \Illuminate\Http\Request $request
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_Input';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('input_get', [$this->request, 'input']),
			new Twig_SimpleFunction('input_old', [$this->request, 'old']),
		];
	}
}