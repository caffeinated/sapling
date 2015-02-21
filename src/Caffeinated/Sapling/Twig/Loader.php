<?php
namespace Caffeinated\Sapling\Twig;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\ViewFinderInterface;
use InvalidArgumentException;
use Twig_Error_Loader;
use Twig_ExistsLoaderInterface;
use Twig_LoaderInterface;

class Loader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{
	/**
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $files;

	/**
	 * @var \Illuminate\View\ViewFinderInterface
	 */
	protected $finder;

	/**
	 * @var string
	 */
	protected $extension;

	/**
	 * @var array
	 */
	protected $cache = [];

	/**
	 * Constructor.
	 *
	 * @param Filesystem           $files
	 * @param ViewFinderInterface  $finder
	 * @param string               $extension
	 */
	public function __construct(Filesystem $files, ViewFinderInterface $finder, $extension = 'twig.php')
	{
		$this->files     = $files;
		$this->finder    = $finder;
		$this->extension = $extension;
	}

	/**
	 * Get the fully qualified location of the template.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function findTemplate($name)
	{
		if ($this->files->exists($name)) {
			return $name;
		}

		$name = $this->normalizeName($name);

		if (isset($this->cache[$name])) {
			return $this->cache[$name];
		}

		try {
			$this->cache[$name] = $this->finder->find($name);
		} catch (InvalidArgumentException $e) {
			throw new Twig_Error_Loader($e->getMessage());
		}

		return $this->cache[$name];
	}

	/**
	 * Gets the normalized filename for a given template.
	 *
	 * @param  string $name  The template name
	 * @return string        The normalized filename
	 */
	protected function normalizeName($name)
	{
		if ($this->files->extension($name) === $this->extension) {
			$name = substr($name, 0, -(strlen($this->extension) + 1));
		}

		return $name;
	}

	/**
	 * Check if we have the source code of a template, given its name.
	 *
	 * @param  string  $name  The name of the template to check if we can load
	 * @return bool           If the template source code is handled by this loader or not
	 */
	public function exists($name)
	{
		try {
			$this->findTemplate($name);
		} catch (Twig_Error_loader $e) {
			return false;
		}

		return true;
	}

	/**
	 * Gets the source code of a template, given its name.
	 *
	 * @param  string $name       The name of the template to load
	 * @return string             The template source code
	 * @throws Twig_Error_Loader  When $name is not found
	 */
	public function getSource($name)
	{
		return $this->files->get($this->findTemplate($name));
	}

	/**
	 * Gets the cache key to use for the cache for a given template name.
	 *
	 * @param  string  $name      The name of the template to load
	 * @return string             The cache key
	 * @throws Twig_Error_Loader  When $name is not found
	 */
	public function getCacheKey($name)
	{
		return $this->findTemplate($name);
	}

	/**
	 * Returns true if the template is still fresh.
	 *
	 * @param  string     $name   The template name
	 * @param  timestamp  $time   The last modification time of the cached template
	 * @return bool               true if the template is fresh, false otherwise
	 * @throws Twig_Error_Loader  When $name is not found
	 */
	public function isFresh($name, $time)
	{
		return $this->files->lastModified($this->findTemplate($name)) <= $time;
	}
}
