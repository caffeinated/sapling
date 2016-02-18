<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Illuminate\Config\Repository;
use Twig_Extension;
use Twig_SimpleFunction;

class Config extends Twig_Extension
{
	/**
	 * @var \Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Create a new Config Twig_Extension instance.
	 *
	 * @param \Illuminate\Config\Repository $config
	 */
	public function __construct(Repository $config)
	{
		$this->config = $config;
	}

	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_Config';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('config_get', [$this->config, 'get']),
			new Twig_SimpleFunction('config_has', [$this->config, 'has']),
		];
	}
}