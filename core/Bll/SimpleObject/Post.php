<?php
namespace Bll\SimpleObject;
class Post extends SimpleObject
{
	function __construct(array $data)
	{
		parent::__construct();
		$this->data = $data;
	}

	public function getTitle()
	{
		return $this->data['title'];
	}

	public function getLocalUrl()
	{
		return '/post/' . $this->getAuthorName() .'/' . $this->getId();
	}

	public function getAuthorName()
	{
		return $this->getAuthor()->getName();
	}

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

	public function getImage($small = false)
	{
		return $this->application->configuration->getStaticRoot() . 'old/pstmgs/' . ($this->getId() % 20) . '/' . ($this->getAuthorId() % 20) . '/' . $this->getId() . ($small ? '_s' : '') . '.jpg';
	}
}