<?php
namespace Caffeinated\Sapling;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\ViewServiceProvider;
use InvalidArgumentException;
use Twig_Loader_Filesystem;
use Twig_Environment;

class SaplingServiceProvider extends ViewServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Boot the service provider
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../../config' => config_path('sapling.php')
		], 'config');
	}

	/**
	 * Register the service provider
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/../../config/sapling.php', 'sapling'
		);

		$this->registerEngineResolver();

		$this->registerViewFinder();

		$this->registerFactory();

		$this->bindCollectiveHtml();
	}

	/**
	 * Register the engine resolver instance.
	 *
	 * @return void
	 */
	public function registerEngineResolver()
	{
		$self = $this;

		$this->app['view.engine.resolver'] = $this->app->share(function() use ($self) {
			$resolver = new EngineResolver;

			// Next we will register the various engines with the resolver so that the
			// environment can resolve the engines it needs for various views based
			// on the extension of view files. We call a method for each engines.
			foreach (array('php', 'blade', 'twig') as $engine)
			{
				$self->{'register'.ucfirst($engine).'Engine'}($resolver);
			}

			return $resolver;
		});
	}

	/**
	 * Register the Twig engine implementation.
	 *
	 * @param  \Illuminate\View\Engines\EngineResolver  $resolver
	 * @return void
	 */
	public function registerTwigEngine($resolver)
	{
		$paths = $this->app['config']['view.paths'];

		$loader = new Twig_Loader_Filesystem($paths);
		$twig   = new Twig_Environment($loader);

		$this->registerExtensions($twig);

		$resolver->register('twig', function() use ($twig) {
			return new Engines\TwigEngine($twig);
		});
	}

	/**
	 * Register the view finder implementation.
	 *
	 * @return void
	 */
	public function registerViewFinder()
	{
		$this->app['view.finder'] = $this->app->share(function() {
			$paths = $this->app['config']['view.paths'];

			return new FileViewFinder($this->app['files'], $paths);
		});
	}

	/**
	 * Register the view environment.
	 *
	 * @return void
	 */
	public function registerFactory()
	{
		$self = $this;

		$this->app['view'] = $this->app->share(function() use ($self) {
			// Next we need to grab the engine resolver instance that will be used by the
			// environment. The resolver will be used by an environment to get each of
			// the various engine implementations such as plain PHP, Twig, or Blade.
			$resolver = $this->app['view.engine.resolver'];

			$finder = $this->app['view.finder'];

			$env = new Factory($resolver, $finder, $this->app['events']);

			// We will also set the container instance on this view environment since the
			// view composers may be classes registered in the container, which allows
			// for great testable, flexible composers for the application developer.
			$env->setContainer($this->app);

			$env->share('app', $this->app);

			return $env;
		});
	}

	/**
	 * Register the Laravel Twig extensions.
	 *
	 * @param  Twig_Environment $twig
	 * @return void
	 */
	public function registerExtensions($twig)
	{
		$extensions = $this->app['config']['sapling.extensions'];

		foreach ($extensions as $extension) {
			if (is_string($extension)) {
				try {
					$extension = $this->app->make($extension);
				} catch (\Exception $e) {
					throw new InvalidArgumentException(
						"Cannot instaniate Twig extension '{$extension}': ".$e->getMessage()
					);
				}
			} elseif (is_callable($extension)) {
				$extension = $extension($this->app, $twig);
			} elseif (! is_a($extension, 'Twig_Extension')) {
				throw new InvalidArgumentException('Incorrect extension type');
			}

			$twig->addExtension($extension);
		}
	}

	/**
	 * Bind the Collective Html package to the IOC container.
	 *
	 * @return null|Collective\Html\FormBuilder
	 */
	public function bindCollectiveHtml()
	{
		if (class_exists('Collective\Html\FormBuilder')) {
			$this->app->bind('Collective\Html\FormBuilder', function() {
				return new \Collective\Html\FormBuilder(
					$this->app->make('Collective\Html\HtmlBuilder'),
					$this->app->make('Illuminate\Routing\UrlGenerator'),
					csrf_token()
				);
			});
		}
	}
}