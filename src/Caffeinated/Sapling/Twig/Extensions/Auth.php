<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Illuminate\Auth\AuthManager;
use Twig_Extension;
use Twig_SimpleFunction;

class Auth extends Twig_Extension
{
	/**
	 * @var \Illuminate\Auth\AuthManager
	 */
	protected $auth;

	/**
	 * Create a new Auth Twig_Extension instance.
	 *
	 * @param \Illuminate\Auth\AuthManager $auth
	 */
	public function __construct(AuthManager $auth)
	{
		$this->auth = $auth;
	}

	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_Auth';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('auth_check', [$this->auth, 'check']),
			new Twig_SimpleFunction('auth_guest', [$this->auth, 'guest']),
			new Twig_SimpleFunction('auth_user', [$this->auth, 'user']),
		];
	}
}