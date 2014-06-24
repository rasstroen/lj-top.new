<?php
/**
 * @var $response Response
 */
?>
<!DOCTYPE html>
<head>
	<title><?=Lib_Util_Html::encode($response->getPageTitle());?></title>
	<?php
	foreach($response->getCssLinks() as $link)
	{
		echo '<link rel="stylesheet" href="' . Lib_Util_Html::encode($link) . '">' . "\n";
	}
	?>
</head>