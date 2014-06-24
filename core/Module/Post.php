<?php
namespace Module;

use Lib\Paging;

class Post extends \Module
{
	private $postsPerPage = 20;
	public function actionShowItem()
	{


		$author = $this->application->bll->authors->getByName($this->variables['authorName']);
		$post = $this->application->bll->posts->getById($this->variables['postId'], $author->getId());

		$pageTitle = $this->variables['authorName'] . ' — ' . $post->getTitle();
		$this->application->response->setPageTitle($pageTitle);

		return array(
			'post'      => $post,
		);
	}

	public function actionListMain()
	{
		$currentPage    = $this->application->request->getQueryParam('p', 1);
		$paging         = new Paging($this->postsPerPage, $currentPage);
		list($posts, $totalFound)     = $this->application->bll->posts->getPopular($paging);
		uasort(
			$posts,
			function($a, $b)
			{
				return $b->getRating() - $a	->getRating();
			}
		);

		$paging->setItemsCount($totalFound);
		if($paging->getRealPage() !== $paging->getCurrentPage())
		{
			$this->application->request->redirect(
				$this->application->request->getCurrentUrl(
					array(
						'p' => $paging->getRealPage()
					)
				)
			);
		}

		return array(
			'posts'     => $posts,
			'paging'    => $paging,
		);
	}
}