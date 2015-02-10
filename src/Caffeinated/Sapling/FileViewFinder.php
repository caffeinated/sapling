<?php
namespace Caffeinated\Sapling;

class FileViewFinder extends \Illuminate\View\FileViewFinder
{
	/**
	 * Register a view extension with the finder.
	 *
	 * @var array
	 */
	protected $extensions = array('blade.php', 'php', 'twig');
}