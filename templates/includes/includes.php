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