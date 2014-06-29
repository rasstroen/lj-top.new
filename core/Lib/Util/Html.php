<?php
class Lib_Util_Html
{
	public static function encode($string)
	{
		return htmlspecialchars($string);
	}

	public static function cutHtml($text, $length, $afterText = '...')
	{
		$text = str_replace(
			array(
				'<br/>',
				'<br />',
				'<br>',
			),
			"\n",
			$text
		);
		$result     = '';
		$text       = explode(" ", strip_tags($text));
		$i          = 0;
		$resultLen  = 0;
		$wordsCount = count($text);
		while($i< $wordsCount && $resultLen < $length)
		{
			$resultLen += strlen($text[$i]);
			$result .= ' ' . $text[$i];
			$i++;
		}
		return $result . (($i<$wordsCount) ? $afterText : '');
	}
}