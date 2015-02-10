<?php

return [
	
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
		'Caffeinated\Sapling\Twig\Extensions\String',
		'Caffeinated\Sapling\Twig\Extensions\Url',

		// 'Caffeinated\Sapling\Twig\Extensions\Form',
		// 'Caffeinated\Sapling\Twig\Extensions\Html',
	],

];