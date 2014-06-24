<?php
namespace Application\Exception;
class Http extends \Application\Exception{
	function __construct($code)
	{
		$this->code = $code;
	}
}