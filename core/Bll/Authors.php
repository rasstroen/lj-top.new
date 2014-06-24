<?php
namespace Bll;

use Bll\SimpleObject\Author;
use Lib\Paging;

class Authors extends Component
{
	public function getById($id)
	{
		$data = $this->application->db->web->selectRow('SELECT * FROM `author` WHERE id = ?', array($id));
		return new Author($data);
	}

	public function getByName($name)
	{
		$data = $this->application->db->web->selectRow('SELECT * FROM `author` WHERE name = ?', array($name));
		return new Author($data);
	}
}