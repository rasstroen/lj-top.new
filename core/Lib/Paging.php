<?php
namespace Lib;

class Paging
{
	private $currentPage;
	private $perPage;
	private $itemsCount;

	function __construct($perPage, $currentPage)
	{
		$this->perPage      = intval($perPage);
		$this->currentPage  = $currentPage;
	}

	public function getSqlPatch()
	{
		return 'LIMIT ' . intval(($this->currentPage-1) * $this->perPage) . ', ' . intval($this->perPage);
	}

	public function getPageSize()
	{
		return $this->perPage;
	}

	public function getMaxPage()
	{
		return ceil($this->itemsCount / $this->perPage);
	}

	public function getRealPage()
	{
		return (string)($this->getMaxPage() < $this->currentPage ? $this->getMaxPage() : ($this->currentPage < 1 ? 1 : intval($this->currentPage)));
	}

	public function setItemsCount($itemsCount)
	{
		$this->itemsCount = max(0, intval($itemsCount));
	}

	public function getCurrentPage()
	{
		return (string)$this->currentPage;
	}

	public function getItemsCount()
	{
		return $this->itemsCount;
	}
}