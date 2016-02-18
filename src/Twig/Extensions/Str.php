<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;
use Illuminate\Support\Str as IlluminateStr;

class Str extends Twig_Extension
{
	/**
	 * @var string|object
	 */
	protected $callback = 'Illuminate\Support\Str';

	/**
	 * Return the string object callback.
	 *
	 * @return string|object
	 */
	public function getCallback()
	{
		return $this->callback;
	}

	/**
	 * Set a new string callback.
	 *
	 * @param  string|object
	 * @return void
	 */
	public function setCallback($callback)
	{
		$this->callback = $callback;
	}

	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_String';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('ends_with', [$this->callback, 'endsWith']),
			new Twig_SimpleFunction('starts_with', [$this->callback, 'startsWith']),
			new Twig_SimpleFunction('str_*', function($name) {
				$arguments = array_slice(func_get_args(), 1);
				$name      = IlluminateStr::camel($name);

				return call_user_func_array([$this->callback, $name], $arguments);
			}),
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
			new Twig_SimpleFilter('camel_case', [$this->callback, 'camel']),
			new Twig_SimpleFilter('snake_case', [$this->callback, 'snake']),
			new Twig_SimpleFilter('studly_case', [$this->callback, 'studly']),
			new Twig_SimpleFilter('str_*', function($name) {
				$arguments = array_slice(func_get_args(), 1);
				$name      = IlluminateStr::camel($name);

				return call_user_func_array([$this->callback, $name], $arguments);
			}),
		];
	}
}
