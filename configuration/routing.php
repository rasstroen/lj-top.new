<?php
return array(
	'map' => array(
		'' => 'index',
		'post' => array(
			'%s' => array(
				'_var'  => 'authorName',
				'' => 'author_posts', // www.domain.ru/%post%/%authorName%
				'%d' => array(
					'_var'  => 'postId',
					'' => 'author_post' // www.domain.ru/post/%authorName%/%postId%
				),
			)
		)
	),
	'pages' => array(
		/**
		 * Настройки по умолчанию
		 */
		'default'   => array(
			'layout'    => 'two_columns', // шапка, футер, 2 колонки
			'cache'     => 0, // nginx кеширование
			'css'       => array(
				'common', // общий сss для проекта
			),
			'js'        => array(
				'common', // общий js для всего проекта
			),
			'blocks'    => array(
				// шапка
				'header' => array(
					/**
					 * Шапка сайта
					 */
					'siteHeader' => array(
							'module'            => 'Html', // класс \Module\Html
							'action'            => 'show',
							'mode'              => 'header', // метод класса showHeader()
							'template'          => 'stuff',
							'template_method'   => 'show_header',
							'cache'             => 120, // nginx кеш на 2 минуты
							'ssi'               => true // показываем через ssi
					),
				),
				// футер
				'footer' => array(),
				// левая колонка
				'left' => array(),
				// правая колонка
				'right' => array(),
			)
		),
		/**
		 * 404
		 */
		'404' => array(
			'layout'    => '404',
		),
		/**
		 * Главная
		 */
		'index' => array(
			'blocks' => array(
				'left'   => array(
					'postList'  => array(
						'module'            => 'Post', // класс \Module\Html
						'action'            => 'list',
						'mode'              => 'main', // метод класса showHeader()
						'cache'             => 120, // nginx кеш на 2 минуты
						'ssi'               => true // показываем через ssi
					),
				)
			),
		),
		/**
		 * Страница поста автора
		 */
		'author_post' => array(
			'blocks'    => array(
				'header' => array(
					/**
					 * Шапка сайта - другой шаблон
					 */
					'siteHeader'  => array(
							'template_method'   => 'show_header_author',
					),
				),
				'left' => array(
					/**
					 * Один пост
					 */
					'postItem'  => array(
							'module'            => 'Post', // класс \Module\Html
							'action'            => 'show',
							'mode'              => 'item', // метод класса showHeader()
							'cache'             => 120, // nginx кеш на 2 минуты
							'ssi'               => true // показываем через ssi
					),
				),
			),
		),
	),
);