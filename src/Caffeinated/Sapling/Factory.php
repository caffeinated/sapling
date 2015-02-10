<?php
namespace Caffeinated\Sapling;

class Factory extends \Illuminate\View\Factory
{
	/**
	 * The extension to engine bindings.
	 *
	 * @var array
	 */
	protected $extensions = array('blade.php' => 'blade', 'php' => 'php', 'twig' => 'twig');
}