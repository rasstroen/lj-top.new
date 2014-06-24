<?php

class Module
{
	protected $configuration;
	/**
	 * @var Application
	 */
	protected $application;
	protected $variables;

	private $data = array();

	public function __construct(array $configuration)
	{
		$this->configuration = $configuration;
	}

	public function setApplication(Application $application)
	{
		$this->application = $application;
	}

	public function setVariables(array $variables)
	{
		$this->variables        = $variables;
		$this->data['variables'] = $variables;
	}

	public function run($methodName)
	{
		$this->data[$methodName] = $this->$methodName();
		return $this->data[$methodName];
	}
}