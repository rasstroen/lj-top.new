<?php
return array(
	'root' => '/home/global.lj-top.ru/',
	'defaultPageTitle'  => 'популярные записи рейтинга блогов Живого Журнала',
	'components' => array(
		'db' => array(
			'class'=>'\\Database\\Factory'
		)
	),
	'db' => array(
		'web' => array(
			'username'  => 'root',
			'password'  => 2912,
			'port'      => 3306,
			'database'  => 'ljtop',
			'host'      => '127.0.0.1'
		),
	)
);