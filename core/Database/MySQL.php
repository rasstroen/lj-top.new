<?php
namespace Database;

class MySQL
{
	private $pdo;
	function __construct($pdo)
	{
		$this->pdo = $pdo;
		$this->query('SET NAMES utf8');
	}

	/**
	 * Возвращает массив ассоциативных массивов с результатом выборки
	 * или пустой массив
	 *
	 * @param $query
	 * @param array $parameters
	 * @param null $keyfield
	 * @return array
	 */
	public function sql2array($query, array $parameters = array(), $keyfield = null)
	{
		$out = array();
		$result = $this->query($query, $parameters);
		$i = 0;
		while ($data = $result->fetch(\PDO::FETCH_ASSOC))
		{
			$out[$keyfield ? $data[$keyfield] : $i++] = $data;
		}
		return $out;
	}

	public function selectSingle($query, array $parameters = array())
	{
		$out    = array();
		$result = $this->query($query, $parameters);
		while ($data = $result->fetch(\PDO::FETCH_ASSOC)) {
			$out = array_shift($data);
		}
		return $out;
	}

	public function sql2row($query, array $parameters = null, $keyfield = null)
	{
		$result = $this->sql2array($query, $parameters, $keyfield);
		return array_shift($result);
	}

	/**
	 * Возвращает значение из бд или null
	 *
	 * @param $query
	 * @param array $parameters
	 * @return mixed|null
	 */
	public function sql2single($query, array $parameters = null)
	{
		$result = $this->query($query, $parameters);
		$data = $result->fetch(\PDO::FETCH_ASSOC);
		if (count($data))
		{
			return array_pop($data);
		}
		return null;
	}

	public function query($query, array $parameters = array())
	{
		$stmt = $this->pdo->prepare($query);

		if ($stmt->execute($parameters))
		{
			return $stmt;
		}
		else
		{
			$errorInfo = $stmt->errorInfo();
			throw new Exception('Database error:' . print_r($errorInfo, true));
		}
	}
}