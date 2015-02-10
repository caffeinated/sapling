<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Collective\Html\FormBuilder;
use Illuminate\Support\Str;
use Twig_Extension;
use Twig_SimpleFunction;

class Form extends Twig_Extension
{
	/**
	 * @var \Collective\Html\FormBuilder
	 */
	protected $form;

	/**
	 * Create a new Form Twig_Extension instance.
	 *
	 * @param \Collective\Html\FormBuilder $form
	 */
	public function __construct(FormBuilder $form)
	{
		$this->form = $form;
	}

	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_Form';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('form_*', function($name) {
				$arguments = array_slice(func_get_args(), 1);
				$name      = Str::camel($name);

				return call_user_func_array([$this->form, $name], $arguments);
			}, ['is_safe' => ['html']]),
		];
	}
}