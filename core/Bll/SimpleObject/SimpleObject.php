<?php
namespace Bll\SimpleObject;
class SimpleObject
{
	protected $data;
	protected $application;
	function __construct()
	{
		$this->application = \Application::i();
	}

}