<?php
namespace Database;
/**
 * Class Factory
 * @package Database
 *
 *
 * @property MySQL $web
 */
class Factory
{
	private $connections;
	public function __get($connectionName)
	{
		if(!isset($this->connections[$connectionName]))
		{
			$dbConfig = \Application::i()->configuration->getDbConfiguration($connectionName);
			$dsn = $this->getDsn($dbConfig);
			$this->connections[$connectionName] = new MySQL(new \PDO($dsn, $dbConfig['username'], $dbConfig['password']));
		}
		return $this->connections[$connectionName];
	}

	private function getDsn(array $dbConfig)
	{
		$dbName = $dbConfig['database'];
		$dbHost = $dbConfig['host'];
		return 'mysql:dbname=' . $dbName . ";host=" . $dbHost;
	}
}