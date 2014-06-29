<?php
function postListMain($data)
{
	?><h1>Популярные записи</h1><ul><?php
	paging_inc($data['paging']);
	foreach($data['posts'] as $post)
	{
		__listPostItem($post);
	}
	?></ul><?
}

function postShowItem(array $data)
{
	__showPostItem($data['post']);
}