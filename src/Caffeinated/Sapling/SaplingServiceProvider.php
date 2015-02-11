<?php
namespace Caffeinated\Sapling;

use Illuminate\View\ViewServiceProvider;
use Twig_Environment;
use Twig_Loader_Array;
use Twig_Loader_Chain;


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

		$this->addFileExtension();
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

		$this->bindTwigOptions();

		$this->bindTwigLoaders();

		$this->bindTwigEngine();

		$this->bindCollectiveHtml();
	}

	protected function bindTwigOptions()
	{
		$this->app->bindIf('sapling.twig.fileextension', function() {
			return $this->app['config']->get('sapling.file_extension');
		});

		$this->app->bindIf('sapling.twig.options', function() {
			$options = $this->app['config']->get('sapling.environment_options', []);

			if (empty($options['cache'])) {
				$options['cache'] = $this->app['path.storage'].'/views/twig';
			}

			return $options;
		});

		$this->app->bindIf('sapling.twig.extensions', function() {
			$load = $this->app['config']->get('sapling.extensions', []);

			$options = $this->app['sapling.twig.options'];
			$debug   = (bool) (isset($options['debug'])) ? $options['debug'] : false;

			if ($debug) {
				array_unshift($load, 'Twig_Extension_Debug');
			}

			return $load;
		});

		$this->app->bindIf('sapling.twig.lexer', function() {
			return null;
		});
	}

	protected function bindTwigLoaders()
	{
		$this->app->bindIf('sapling.twig.templates', function() {
			return [];
		});

		$this->app->bindIf('sapling.twig.loader.array', function($app) {
			return new Twig_Loader_Array($app['sapling.twig.templates']);
		});

		$this->app->bindIf('sapling.twig.loader.viewfinder', function() {
			return new Twig\Loader($this->app['files'], $this->app['view']->getFinder(), $this->app['sapling.twig.fileextension']);
		});

		$this->app->bindIf('sapling.twig.loader', function() {
			return new Twig_Loader_Chain([
				$this->app['sapling.twig.loader.array'],
				$this->app['sapling.twig.loader.viewfinder']
			]);
		});
	}

	protected function bindTwigEngine()
	{
		$this->app->bindIf('sapling.twig', function() {
			$extensions = $this->app['sapling.twig.extensions'];
			$lexer      = $this->app['sapling.twig.lexer'];
			$twig       = new Twig\Instance($this->app['sapling.twig.loader'], $this->app['sapling.twig.options'], $this->app);

			foreach ($extensions as $extension) {
				if (is_string($extension)) {
					try {
						$extension = $this->app->make($extension);
					} catch (Exception $e) {
						throw new InvalidArgumentException(
							"Cannot instantiate Twig extension '{$extension}': ".$e->getMessage()
						);
					}
				} elseif (is_callable($extension)) {
					$extension = $extension($this->app, $twig);
				} elseif (! is_a($extension, 'Twig_Extension')) {
					throw new InvalidArgumentException('Incorrect extension type');
				}

				$twig->addExtension($extension);
			}

			if (is_a($lexer, 'Twig_LexerInterface')) {
				$twig->setLexer($lexer);
			}

			return $twig;
		}, true);

		$this->app->alias('sapling.twig', 'Twig_Environment');
		$this->app->alias('sapling.twig', 'Caffeinated\Sapling\Twig\Instance');

		$this->app->bindIf('sapling.twig.compiler', function() {
			return new Engines\Compiler($this->app['sapling.twig']);
		});

		$this->app->bindIf('sapling.twig.engine', function() {
			return new Engines\TwigEngine(
				$this->app['sapling.twig.compiler'],
				$this->app['sapling.twig.loader.viewfinder'],
				$this->app['config']->get('sapling.globals', [])
			);
		});
	}

	protected function addFileExtension()
	{
		$this->app['view']->addExtension($this->app['sapling.twig.fileextension'], 'twig', function() {
			return $this->app['sapling.twig.engine'];
		});
	}

	/**
	 * Bind the Collective Html package to the IOC container.
	 *
	 * @return null|Collective\Html\FormBuilder
	 */
	protected function bindCollectiveHtml()
	{
		if (class_exists('Collective\Html\FormBuilder')) {
			$this->app->bindIf('Collective\Html\FormBuilder', function() {
				return new \Collective\Html\FormBuilder(
					$this->app->make('Collective\Html\HtmlBuilder'),
					$this->app->make('Illuminate\Routing\UrlGenerator'),
					csrf_token()
				);
			});
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
			'sapling.twig',
			'sapling.twig.engine',
			'sapling.twig.fileextension',
			'sapling.twig.extensions',
			'sapling.twig.options',
			'sapling.twig.loader',
			'sapling.twig.loader.array',
			'sapling.twig.loader.path',
			'sapling.twig.loader.viewfinder',
			'sapling.twig.templates',
		];
	}
}