<?php
namespace Bll\SimpleObject;
class SimpleObject
{
	protected $data;
	function __construct()
	{
		$this->application = \Application::i();
	}

}