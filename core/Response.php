<?php

/**
 * Class Response
 */
class Response extends Component
{
	private $moduleData = array();
	/**
	 * @var \Controller\Configuration
	 */
	private $configuration;

	public function getCssLinks()
	{
		$links = array();
		foreach($this->configuration->getParam('css') as $cssLine)
		{
			$links[] = $this->getApplication()->configuration->getStaticRoot() . 'css/' . $cssLine . '.css';
		}
		return $links;
	}

	public function getPageTitle()
	{
		$pageTitle =  isset($this->pageProperties['title']) ? $this->pageProperties['title'] : $this->configuration->getPageTitle();
		if($pageTitle)
		{
			return $pageTitle . ' — ' . $this->getApplication()->configuration->getDefaultPageTitle();
		}
		else
		{
			return $this->getApplication()->configuration->getDefaultPageTitle();
		}
	}

	public function setPageTitle($pageTitle)
	{
		$this->pageProperties['title'] = $pageTitle;
	}

	public function setConfiguration(\Controller\Configuration $configuration)
	{
		$this->configuration = $configuration;
		return $this;
	}

	public function setModuleData($block, $moduleName, $moduleAction, $moduleMode, array $data = null)
	{
		$this->moduleData[$block][$moduleName][$moduleAction][$moduleMode] = $data;
	}

	public function getModuleData($blockModule)
	{
		$block          = $blockModule['block'];
		$moduleName     = $blockModule['module'];
		$moduleAction   = $blockModule['action'];
		$moduleMode     = $blockModule['mode'];
		return isset($this->moduleData[$block][$moduleName][$moduleAction][$moduleMode]) ? $this->moduleData[$block][$moduleName][$moduleAction][$moduleMode] : array();
	}

	public function getBlockModules($blockName)
	{
		return $this->configuration->getModules($blockName);
	}

	public function render()
	{
		global $response;
		$response =  $this;
		require $this->configuration->getLayoutFile();
	}
}