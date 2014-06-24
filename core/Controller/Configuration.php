<?php
namespace Controller;
/**
 * Class Configuration - конфигурация контроллера, по которой он будет выполняться в этом запросе
 * @package Controller
 */
class Configuration
{
	private $configuration;

	public function __construct(array $controllerConfigurationArray)
	{
		$this->configuration = $controllerConfigurationArray;
	}

	public function getPageTitle()
	{
		return isset($this->configuration['title']) ? $this->configuration['title'] : '';
	}

	public function getParam($paramName)
	{
		return $this->configuration[$paramName];
	}

	public function getLayoutFile()
	{
		return \Application::i()->configuration->getTemplatesPath() . 'layouts/' . $this->configuration['layout'] . '.php';
	}

	public function getModules($targetBlockName = null)
	{
		$modulesArray = array();
		foreach($this->configuration['blocks'] as $blockName => $modules)
		{
			if($targetBlockName && $blockName !== $targetBlockName) continue;
			foreach($modules as $moduleName => $moduleConfiguration)
			{
				$modulesArray[$moduleName]          = $moduleConfiguration;
				$modulesArray[$moduleName]['block'] = $blockName;
			}
		}
		return $modulesArray;
	}
}