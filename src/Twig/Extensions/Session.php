<?php
namespace Caffeinated\Sapling\Twig\Extensions;

use Illuminate\Session\SessionManager;
use Twig_Extension;
use Twig_SimpleFunction;

class Session extends Twig_Extension
{
	/**
	 * @var \Illuminate\Session\SessionManager
	 */
	protected $session;

	/**
	 * Create a new Session Twig_Extension instance.
	 *
	 * @param \Illuminate\Session\SessionManager $session
	 */
	public function __construct(SessionManager $session)
	{
		$this->session = $session;
	}

	/**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
	public function getName()
	{
		return 'Caffeinated_Sapling_Extension_Session';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('csrf_token', [$this->session, 'token'], ['is_safe' => ['html']]),
			new Twig_SimpleFunction('session_get', [$this->session, 'get']),
			new Twig_SimpleFunction('session_pull', [$this->session, 'pull']),
			new Twig_SimpleFunction('session_has', [$this->session, 'has']),
		];
	}
}