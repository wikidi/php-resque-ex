<?php
class Resque_Redis extends Redis
{
	private static $defaultNamespace = 'resque:';

	public function __construct($host, $port, $timeout = 5)
	{
		parent::__construct();

		$this->host = $host;
		$this->port = $port;
		$this->timeout = $timeout;

		$this->establishConnection();
	}

	function establishConnection()
	{
		$this->pconnect($this->host, (int) $this->port, (int) $this->timeout);
		$this->setOption(Redis::OPT_PREFIX, self::$defaultNamespace);
	}

	public function prefix($namespace)
	{
		if (empty($namespace)) $namespace = self::$defaultNamespace;
		if (strpos($namespace, ':') === false) {
			$namespace .= ':';
		}
		self::$defaultNamespace = $namespace;

		$this->setOption(Redis::OPT_PREFIX, self::$defaultNamespace);
	}
}