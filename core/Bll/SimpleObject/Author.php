<?php
namespace Bll\SimpleObject;
class Author extends SimpleObject
{
	function __construct(array $data)
	{
		parent::__construct();
		$this->data = $data;
	}

	public function getName()
	{
		return $this->data['name'];
	}

	public function getId()
	{
		return $this->data['id'];
	}

	public function getLocalUrl()
	{
		return '/author/' . rawurlencode($this->getName());
	}

}