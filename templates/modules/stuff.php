<?php
function stuffShow_header()
{
	/**
	 * @var Response $response
	 */
	global $response;
	$routing = $response->getApplication()->routing;
	?>
	<div class="stuff_show_header">
		<ul>
			<li><a href="<?=Lib_Util_Html::encode($routing->getIndexUrl())?>">Главная</a></li>
			<li><a href="<?=Lib_Util_Html::encode($routing->getNewestUrl())?>">Cвежие</a></li>
			<li><a href="<?=Lib_Util_Html::encode($routing->getThemeListUrl())?>">Темы</a></li>
			<li><a href="<?=Lib_Util_Html::encode($routing->getNewsListUrl())?>">Новости</a></li>
			<li><a href="<?=Lib_Util_Html::encode($routing->getPublicsUrl())?>">Паблики</a></li>
			<li><a href="<?=Lib_Util_Html::encode($routing->getRatingsUrl())?>">Рейтинги</a></li>
			<li><a href="<?=Lib_Util_Html::encode($routing->getSearchUrl())?>">Поиск</a></li>
		</ul>
	</div>
<?php
}

function stuffShow_header_author()
{
	stuffShow_header();
}