<?php
namespace Caffeinated\Sapling\Twig\Loader;

use Twig_Loader_Filesystem;

class Filesystem extends Twig_Loader_Filesystem
{
	protected function findTemplate($name)
	{
		if (strtolower(substr($name, -5)) !== '.twig') {
			$name = str_replace('.', DIRECTORY_SEPARATOR, $name);		

			$name .= '.twig';
		}

		return parent::findTemplate($name);
	}
}