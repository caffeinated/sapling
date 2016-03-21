<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Collective\Html\HtmlBuilder;
use Twig_Extension;
use Twig_SimpleFunction;

class Html extends Twig_Extension
{
	/**
	 * @var \Collective\Html\HtmlBuilder
	 */
	protected $html;

	/**
	 * Create a new Html Twig_Extension instance.
	 *
	 * @param \Collective\Html\HtmlBuilder $html
	 */
	public function __construct(HtmlBuilder $html)
	{
		$this->html = $html;
	}

	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_Html';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('link_to', [$this->html, 'link'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('link_to_asset', [$this->html, 'linkAsset'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('link_to_route', [$this->html, 'linkRoute'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('link_to_action', [$this->html, 'linkAction'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('html_*', function($name) {
				$arguments = array_slice(func_get_args(), 1);
				$name      = camel_case($name);

				return call_user_func_array([$this->html, $name], $arguments);
			}, ['is_safe' => ['html']]),
		];
	}
}
