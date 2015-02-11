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

		'debug' => Config::get('app.debug', false),

		'charset' => 'utf-8',

		'base_template_class' => 'Caffeinated\Sapling\Twig\Template',

		'cache' => null,

		'auto_reload' => true,

		'strict_variables' => false,

		'autoescape' => true,

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
		'Caffeinated\Sapling\Twig\Extensions\Session',
		'Caffeinated\Sapling\Twig\Extensions\String',
		'Caffeinated\Sapling\Twig\Extensions\Translator',
		'Caffeinated\Sapling\Twig\Extensions\Url',

		'Caffeinated\Sapling\Twig\Extensions\Form',
		'Caffeinated\Sapling\Twig\Extensions\Html',
	],

];