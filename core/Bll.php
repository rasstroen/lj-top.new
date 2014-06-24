<?php

/**
 * Class Bll
 *
 * @property \Bll\Posts 	$posts
 * @property \Bll\Authors 	$authors
 */
class Bll extends Component
{
	private $components;

	public function __get($componentName)
	{
		$componentName = ucfirst($componentName);
		return isset($this->components[$componentName]) ? $this->components[$componentName] : $this->createComponent($componentName);
	}

	private function createComponent($componentName)
	{
		$componentName = 'Bll\\' . ucfirst($componentName);
		$this->components[$componentName] = new $componentName($this->getApplication());
		return $this->components[$componentName];
	}
}