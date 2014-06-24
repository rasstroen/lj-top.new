<?php
header('X-Accel-Expires: 0');
error_reporting(E_ALL);
ini_set('display_errors', true);
/**
 * Конфигурация сервера
 */
$configuration = require_once '../configuration/config.php';
/**
 * Конфигцрация роутинга
 */
$configuration['routing'] = require_once '../configuration/routing.php';

/**
 * Автолоадер
 */
$includePathes = array($configuration['root'] . 'core');
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $includePathes));
require_once $configuration['root'] . 'core/AutoLoad.php';
/**
 * Создаем экземпляр приложения
 */
$application = new Application(
	new \Application\Configuration(
		$configuration
	)
);
/**
 * Запускаем обработку
 */
try
{
	$application->run();
}
catch (\Application\Exception\Http $exception)
{
	switch ($exception->getCode())
	{
		case 404:
			header('404 Not Found', true, 404);
			$application->response->setConfiguration(
				$application->configuration->getRouteConfigurationByKey('404')
			)->render();
			break;
		default:
			die($exception->getCode());
	}

}
/**
 * Выдаем ответ
 */
$application->flush();