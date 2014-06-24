<?php

class Component
{
	/**
	 * @var Application
	 */
	private $application;

	public function __construct(Application $application)
	{
		$this->application = $application;
	}
	/**
	 * @return Application
	 */
	public function getApplication()
	{
		return $this->application;
	}
}