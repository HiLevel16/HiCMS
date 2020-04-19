<?php

return [
	'login-header' => [ //template name
		'login-header' => [ //point to replace
			'css' => [ //language
				'css/login-header',//path without extension
				'semanticui/semantic.min'
			],
			'js' => [
				'js/login',
				'semanticui/semantic.min'
			]
		]
	],
	'header' => [
		'styles' => [
			'css' => [
				'css/bootstrap' => 'media="all"',//path without extension
				'semanticui/semantic.min' => 'media="all"',
                'css/style'
			],
			'js' => [
				'js/main'
			]
		]
	]

];
