<?php
class Lib_Util_Html
{
	public static function encode($string)
	{
		return htmlspecialchars($string);
	}
}