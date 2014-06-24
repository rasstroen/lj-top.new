<?php

/**
 * Class Application
 *
 * @property    Request                         $request
 * @property    \Database\Factory               $db
 * @property    Controller                      $controller
 * @property    Routing                         $routing
 * @property    \Application\Configuration      $configuration
 * @property    BLL                             $bll
 * @property    Response						$response
 *
 */
class Application
{
	private static $instance;
	/**
	 * @var Component[]
	 */
	private $components;

	public static function i()
	{
		return self::$instance;
	}

	public function __construct(\Application\Configuration $configuration)
	{
		$this->configuration = $configuration;
		return self::$instance = $this;
	}
	/**
	 * Запускаем приложение
	 */
	public function run()
	{
		/**
		 * Получаем конфигурацию контроллера
		 */
		list($configuration, $uriVariables) = $this->routing->getConfigurationByRequest($this->request);
		/** @var $configuration \Controller\Configuration */

		/**
		 * Инициализируем респонс
		 */
		$this->response->setConfiguration($configuration);
		/**
		 * Выполняем модули и передаем результат в Response
		 */

		foreach($configuration->getModules() as $moduleName => $moduleConfiguration)
		{
			$moduleData = $this->runModule($moduleConfiguration, $uriVariables);

			$this->response->setModuleData(
				$moduleConfiguration['block'],
				$moduleConfiguration['module'],
				$moduleConfiguration['action'],
				$moduleConfiguration['mode'],
				$moduleData
			);
		}
		/**
		 *
		 */
	}

	private function runModule(array $moduleConfiguration, array $variables)
	{

		$className  = 'Module\\' . ucfirst($moduleConfiguration['module']);
		$methodName = 'action' . ucfirst($moduleConfiguration['action']) . ucfirst($moduleConfiguration['mode']);
		/**
		 * @var $module Module
		 */
		$module = new $className($moduleConfiguration);
		$module->setVariables($variables);
		$module->setApplication($this);
		return $module->run($methodName);
	}

	/**
	 * Выдаем ответ
	 */
	public function flush()
	{
		$this->response->render();
		/**
		 * Отвечать будет объект респонза
		 */
	}

	public function __get($componentName)
	{
		if($configuration = $this->configuration->getComponentConfiguration($componentName))
		{
			$componentName = $configuration['class'];
		}
		else
		{
			$componentName = ucfirst($componentName);
		}
		return isset($this->components[$componentName]) ? $this->components[$componentName] : $this->createComponent($componentName);
	}

	private function createComponent($componentName)
	{
		$componentName = ucfirst($componentName);
		$this->components[$componentName] = new $componentName($this);
		return $this->components[$componentName];
	}
}