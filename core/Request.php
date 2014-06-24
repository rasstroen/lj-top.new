<?php

class Request extends Component
{
	private $get;
	private $post;
	private $request;
	private $cookie;
	private $files;
	private $requestUri;
	private $referrerUri;
	private $hostInfo;
	private $requestHeaders;
	private $responseHeaders;
	private $responseCookies;

	function __construct(Application $application)
	{
		parent::__construct($application);
		$this->initialize();
	}
	/**
	 * Обрабатываем запрос
	 */
	private function initialize()
	{
		$this->get          = $_GET;
		$this->cookie       = $_COOKIE;
		$this->post         = $_POST;
		$this->request      = array_merge($this->get, $this->post);
		$this->files        = $_FILES;
		$this->requestUri   = $_SERVER['REQUEST_URI'];
		$this->referrerUri  = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

		unset($_REQUEST);
		unset($_FILES);
		unset($_POST);
		unset($_COOKIE);
		unset($_GET);
	}

	public function getQueryParam($paramName, $default = null)
	{
		return isset($this->get[$paramName]) ? $this->get[$paramName] : $default;
	}

	public function getQueryParams()
	{
		return $this->get;
	}

	public function getCurrentUrl(array $applyingParams = null)
	{
		$params = $this->getQueryParams();
		if($params)
		{
			foreach($params as $paramName => $paramValue)
			{
				$params[$paramName] = $paramValue;
			}
		}
		foreach($applyingParams as $paramName => $paramValue)
		{
			$params[$paramName] = $paramValue;
		}
		return '/?' . http_build_query($params);
	}

	public function getRequestUri()
	{
		return $this->requestUri;
	}

	public function redirect($url)
	{
		header('Location: ' . $url);
	}
}