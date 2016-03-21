<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Illuminate\Routing\UrlGenerator;
use Twig_Extension;
use Twig_SimpleFunction;

class Url extends Twig_Extension
{
	/**
	 * @var \Illuminate\Routing\UrlGenerator
	 */
	protected $url;

	/**
	 * Create a new Url Twig_Extension instance.
	 *
	 * @param \Illuminate\Routing\UrlGenerator $url
	 */
	public function __construct(UrlGenerator $url)
	{
		$this->url = $url;
	}

	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_Url';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('asset', [$this->url, 'asset'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('action', [$this->url, 'action'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('url', [$this, 'url'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('route', [$this->url, 'route'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('secure', [$this->url, 'secure'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('secure_asset', [$this->url, 'secureAsset'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('url_*', function($name) {
				$arguments = array_slice(func_get_args(), 1);
				$name      = camel_case($name);

				return call_user_func_array([$this->url, $name], $arguments);
			}),
		];
	}

	/**
	 * Generate a absolute URL to the given path.
	 *
	 * @param  string    $path
	 * @param  mixed     $extra
	 * @param  bool|null $secure
	 * @return string
	 */
	public function url($path = null, $parameters = [], $secure = null)
	{
		return $this->url->to($path, $parameters, $secure);
	}
}
