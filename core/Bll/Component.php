<?php
namespace Bll;
class Component
{
	protected $application;
	protected function getApplication()
	{
		return $this->application;
	}

	function __construct(\Application $application)
	{
		$this->application = $application;
	}
}