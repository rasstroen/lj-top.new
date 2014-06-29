<?php
namespace Bll\SimpleObject;
class Post extends SimpleObject
{
	const BIG_POST_IMAGES_EXISTS_FROM_DATE = 1403640000;
	function __construct(array $data)
	{
		parent::__construct();
		$this->data = $data;
	}

	public function getTitle()
	{
		return $this->data['title'];
	}

	public function getText()
	{
		return $this->data['text'];
	}

	public function getLocalUrl()
	{
		return '/post/' . $this->getAuthorName() .'/' . $this->getId();
	}

	public function getAuthorName()
	{
		return $this->getAuthor()->getName();
	}

	/**
	 * @return Author
	 */
	public function getAuthor()
	{
		return $this->application->bll->authors->getById($this->getAuthorId());
	}

	public function getRating()
	{
		return $this->data['rating'];
	}

	public function getId()
	{
		return $this->data['id'];
	}

	public function getAuthorId()
	{
		return $this->data['author_id'];
	}

	public function hasImage()
	{
		return ((int) $this->data['has_pic'] === 1);
	}

	public function getUpdateTime()
	{
		return $this->data['update_time'];
	}

	public function getShortText()
	{
		return \Lib_Util_Html::cutHtml($this->data['text'], 800);
	}

	public function getImage($small = false)
	{
		if($this->getUpdateTime() < self::BIG_POST_IMAGES_EXISTS_FROM_DATE)
		{
			return $this->application->configuration->getStaticRoot() . 'old/pstmgs/' . ($this->getId() % 20) . '/' . ($this->getAuthorId() % 20) . '/' . $this->getId() . ($small ? '_s' : '') . '.jpg';
		}
		else
		{
			return $this->application->configuration->getStaticRoot() . 'old/pstmgs/' . ($this->getId() % 20) . '/' . ($this->getAuthorId() % 20) . '/' . $this->getId() . ($small ? '_s' : '_b') . '.jpg';
		}
	}
}