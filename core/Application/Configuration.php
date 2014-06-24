<?php
namespace Application;

class Configuration extends \Component
{
	private $configuration;

	function __construct(array $configuration)
	{
		$this->configuration = $configuration;
	}

	public function getDbConfiguration($connectionName)
	{
		return $this->configuration['db'][$connectionName];
	}

	public function getComponentConfiguration($componentName)
	{
		return isset($this->configuration['components'][$componentName]) ?
			$this->configuration['components'][$componentName] : false;
	}

	public function getRoot()
	{
		return $this->configuration['root'];
	}

	public function getTemplatesPath()
	{
		return $this->getRoot() . 'templates/';
	}

	public function getStaticRoot()
	{
		return isset($this->configuration['staticRoot']) ? $this->configuration['staticRoot'] : '/static/';
	}

	public function getDefaultPageTitle()
	{
		return $this->configuration['defaultPageTitle'];
	}

	public function getRouteConfigurationByKey($configurationKey)
	{
		if(!isset($this->configuration['routing']['pages'][$configurationKey]))
		{
			throw new \Exception('No page ' . $configurationKey . ' configuration found');
		}

		$configurationArray     = $this->configuration['routing']['pages'][$configurationKey];
		$defaultConfiguration   = $this->configuration['routing']['pages']['default'];

		$configuration = \Lib_Util_Array::mergeArray($defaultConfiguration, $configurationArray);

		return new \Controller\Configuration($configuration);
	}

	public function getRoutingMap()
	{
		if(!isset($this->configuration['routing']['map']))
		{
			throw new \Exception('No map configuration found');
		}
		return $this->configuration['routing']['map'];
	}
}