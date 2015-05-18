<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Twig File Extension
	|--------------------------------------------------------------------------
	|
	| If you wish, you may specify a custom file extension to use for your
	| Twig templates. By default it is set to 'twig.php' to fall in line with
	| Blade's 'blade.php'; another common extension is to simply use '.htm'
	|
	*/

	'file_extension' => 'twig.php',

	/*
	|--------------------------------------------------------------------------
	| Twig Environmental Configurations
	|--------------------------------------------------------------------------
	|
	*/

	'environment' => [

		/*
		|----------------------------------------------------------------------
		| Debug
		|----------------------------------------------------------------------
		|
		| When set to true, the generated templates have a __toString() method
		| that you can use to display the generated nodes.
		|
		| Default: false
		|
		*/

		'debug' => false,

		/*
		|----------------------------------------------------------------------
		| Charset
		|----------------------------------------------------------------------
		|
		| The charset used by the templates.
		|
		| Default: utf-8
		|
		*/

		'charset' => 'utf-8',

		/*
		|----------------------------------------------------------------------
		| Charset
		|----------------------------------------------------------------------
		|
		| The base template class to use for generated templates.
		|
		| Default: Caffeinated\Sapling\Twig\Template
		|
		*/

		'base_template_class' => 'Caffeinated\Sapling\Twig\Template',

		/*
		|----------------------------------------------------------------------
		| Cache
		|----------------------------------------------------------------------
		|
		| An absolute path where to store the compiled templates, or false to
		| disable caching.
		|
		| Options: false
		|
		*/

		'cache' => false,

		/*
		|----------------------------------------------------------------------
		| Auto Reload
		|----------------------------------------------------------------------
		|
		| When developing with Twig, it's useful to recompile the template
		| whenever the source code changes. If you don't provide a value for
		| the auto_reload option, it will be determined automatically based on
		| the debug value.
		|
		| Default: true
		|
		*/

		'auto_reload' => true,

		/*
		|----------------------------------------------------------------------
		| Strict Variables
		|----------------------------------------------------------------------
		|
		| If set to false, Twig will silently ignore invalid variables
		| (variables and or attributes/methods that do not exist) and replace
		| them with a null value. When set to true, Twig throws an exception
		| instead.
		|
		| Default: false
		|
		*/

		'strict_variables' => false,

		/*
		|----------------------------------------------------------------------
		| Autoescape
		|----------------------------------------------------------------------
		|
		| If set to true, HTML auto-escaping will be enabled by default for all
		| templates.
		|
		| Default: true
		|
		*/

		'autoescape' => true,

		/*
		|----------------------------------------------------------------------
		| Optimization
		|----------------------------------------------------------------------
		|
		| A flag that indicates which optimizations to apply.
		|
		| Default: -1
		|
		*/

		'optimization' => -1,

	],

	/*
	|--------------------------------------------------------------------------
	| Register Twig Extensions
	|--------------------------------------------------------------------------
	|
	| Below you will find a listing of extensions that bring Laravel support
	| to Twig. Feel free to register your own extensions, as well as uncomment
	| the Form and Html extensions if you have the necessary package installed.
	|
	*/

	'extensions' => [
		'Caffeinated\Sapling\Twig\Extensions\Auth',
		'Caffeinated\Sapling\Twig\Extensions\Config',
		'Caffeinated\Sapling\Twig\Extensions\Input',
		'Caffeinated\Sapling\Twig\Extensions\Miscellaneous',
		'Caffeinated\Sapling\Twig\Extensions\Session',
		'Caffeinated\Sapling\Twig\Extensions\String',
		'Caffeinated\Sapling\Twig\Extensions\Translator',
		'Caffeinated\Sapling\Twig\Extensions\Url',

		// 'Caffeinated\Sapling\Twig\Extensions\Form',
		// 'Caffeinated\Sapling\Twig\Extensions\Html',
	],

];
