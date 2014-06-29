<?php
/**
 * @var $response Response
 */
function pageHead_inc()
{
	/**
	 * @var Response $response
	 */
	global $response;
	require_once 'head.php';
}

function processBlock($blockName)
{
	/**
	 * @var $response Response
	 */
	global $response;
	foreach($response->getBlockModules($blockName) as $blockModule)
	{
		$template       = lcfirst(isset($blockModule['template']) ? $blockModule['template'] : $blockModule['module']);
		require_once Application::i()->configuration->getTemplatesPath() . 'modules/' .$template . '.php';
		$templateMethod = isset($blockModule['template_method']) ? $blockModule['template_method'] : ucfirst($blockModule['action']) . ucfirst($blockModule['mode']);
		$functionName   = $template . ucfirst($templateMethod);
		$functionName($response->getModuleData($blockModule));
	}
}

function paging_inc(\Lib\Paging $paging)
{
	$visiblePages   = 10;
	$currentPage    = $paging->getCurrentPage();
	$pageIndexes    = array();
	$minPage        = (ceil($currentPage / $visiblePages) - 1) * $visiblePages;
	$pageIndexes[1] = 1;
	for($i = max(1, $minPage); $i <= min($minPage + $visiblePages + 1, $paging->getMaxPage()); $i++)
	{
		$pageIndexes[$i] = $i;
	}
	$pageIndexes[$paging->getMaxPage()] = $paging->getMaxPage();
	foreach($pageIndexes as $index)
	{
		$class = 'page';
		if($index == $currentPage)
		{
			$class .= ' current';
		}
		?><a class="<?=Lib_Util_Html::encode($class)?>" href="<?=Application::i()->request->getCurrentUrl(array('p' => $index))?>"><?=Lib_Util_Html::encode($index)?></a><?php
	}
}


/**
 * POST
 */

function __listPostItem(\Bll\SimpleObject\Post $post)
{
	?>
	<li class="post list clearfix">
		<h3>
			<a href="<?= Lib_Util_Html::encode($post->getAuthor()->getLocalUrl()); ?>"><?=Lib_Util_Html::encode($post->getAuthor()->getName())?></a>
			<span>:</span>
			<a href="<?= Lib_Util_Html::encode($post->getLocalUrl()); ?>"><?= Lib_Util_Html::encode($post->getTitle()); ?></a>
		</h3>

		<div>
			<? if ($post->hasImage()) { ?>
				<a class="image" href="<?= Lib_Util_Html::encode($post->getLocalUrl()); ?>">
					<img src="<?= $post->getImage() ?>">
				</a>
			<? } ?>
			<div class="text">
				<?= Lib_Util_Html::encode($post->getShortText())?>
			</div>

		</div>
	</li>
<?php
}

function __showPostItem(\Bll\SimpleObject\Post $post)
{
	?>
	<li class="post list clearfix">
		<h3>
			<a href="<?= Lib_Util_Html::encode($post->getAuthor()->getLocalUrl()); ?>"><?=Lib_Util_Html::encode($post->getAuthor()->getName())?></a>
			<span>:</span>
			<a href="<?= Lib_Util_Html::encode($post->getLocalUrl()); ?>"><?= Lib_Util_Html::encode($post->getTitle()); ?></a>
		</h3>

		<div>
			<div class="text">
				<?= $post->getText()?>
			</div>
		</div>
	</li>
<?php
}