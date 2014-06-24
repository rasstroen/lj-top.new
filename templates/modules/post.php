<?php
function postListMain($data)
{
	?><h1>Популярные записи</h1><ul><?php
	paging_inc($data['paging']);
	foreach($data['posts'] as $post)
	{
		/**
		 * @var \Bll\SimpleObject\Post $post
		 */
		?>
		<li class="post list">
			<h3><a href="<?=Lib_Util_Html::encode($post->getLocalUrl());?>"><?=Lib_Util_Html::encode($post->getTitle());?></a></h3>
			<div>
				<?if($post->hasImage()){?>
					<span><img src="<?=$post->getImage()?>"</span>
				<?}?>
			</div>
		</li>
	<?php
	}
	?></ul><?
}

function postShowItem()
{

}