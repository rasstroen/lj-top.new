<?php
/**
 * @var $response Response
 */
require_once $response->getApplication()->configuration->getRoot() . 'templates/includes/includes.php';
pageHead_inc();
?>
<body>
<div class="page">
	<div class="head"><?=processBlock('header');?></div>
	<div class="wrapper">
		<div class="left">
			<h1>Страница не найдена</h1>
		</div>
		<div class="right"><?=processBlock('right');?></div>
	</div>
</div>
<div class="footer"><?=processBlock('footer');?></div>
</body>