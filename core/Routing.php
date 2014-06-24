<?php
class Routing extends Component
{

	public function getIndexUrl()
	{
		return $this->getUrl('');
	}

	public function getNewestUrl()
	{
		return $this->getUrl('newest');
	}

	public function getThemeListUrl()
	{
		return $this->getUrl('theme');
	}

	public function getNewsListUrl()
	{
		return $this->getUrl('news');
	}

	public function getPublicsUrl()
	{
		return $this->getUrl('public');
	}

	public function getRatingsUrl()
	{
		return $this->getUrl('top');
	}

	public function getSearchUrl()
	{
		return $this->getUrl('search');
	}

	private function getUrl($absoluteUrl)
	{
		return '/' . $absoluteUrl;
	}
	/**
	 * определяем конфигурацию страницы, которую будет отдавать
	 *
	 * @param Request $request
	 */
	public function getConfigurationByRequest(Request $request)
	{
		/**
		 * По запросу определяем ключ страницы, которую будет показывать
		 */
		list($configurationKey, $uriVariables) = $this->getConfigurationKeyVariablesByRequest($request);
		/**
		 *  Возвращаем объект - конфигурацию страницы для отрисовки
		 */
		return array($this->getApplication()->configuration->getRouteConfigurationByKey($configurationKey), $uriVariables);
	}

	private function getConfigurationKeyVariablesByRequest(Request $request)
	{
		/**
		 * Получаем карту роутинга
		 */
		$map = $this->getApplication()->configuration->getRoutingMap();

		/**
		 * Чистим requestUri
		 */

		$requestUri = $request->getRequestUri();
		$parameters = '';
		if(strpos($requestUri, '?'))
		{
			list($requestUri, $parameters) = explode('?', $requestUri);
			if($parameters)
			{
				$parameters = '?' . $parameters;
			}
		}
		$requestUriArray            = explode('/', $requestUri);
		$preparedRequestUriArray    = array();
		foreach($requestUriArray as $uriPart)
		{
			if(trim($uriPart))
			{
				$preparedRequestUriArray[] = $uriPart;
			}
		}

		/**
		 * Определяем страницу по очищенному requestUri
		 */

		list($idealRequestUriParts, $pageKey, $uriVariables) = $this->findPageKey($map, $preparedRequestUriArray);

		if($pageKey)
		{
			$idealUrl = '/' . implode('/', $idealRequestUriParts) . $parameters;
		}
		else
		{
			$idealUrl = '/';
		}
		/**
		 * URL неправильный
		 */
		if($idealUrl !== $request->getRequestUri())
		{

			if($pageKey && ($pageKey !== 'index'))
			{
				$request->redirect($idealUrl);
			}
			else
			{
				throw new \Application\Exception\Http(404);
			}
			return;
		}

		return array($pageKey, $uriVariables);
	}

	private function findPageKey($map, $requestArray, $currentIndex = 0, &$idealRequestUriParts = array(), &$variables = array())
	{
		$currentUriPart = isset($requestArray[$currentIndex]) ? $requestArray[$currentIndex] : false;
		if(isset($map['_var']))
		{
			$variables[$map['_var']] = $requestArray[$currentIndex - 1];
			unset($map['_var']);
		}
		foreach($map as $key => $value)
		{
			if($key === $currentUriPart)
			{
				/**
				 * точное совпадение
				 */
				$idealRequestUriParts[] = $currentUriPart;

				if(is_array($value))
				{
					return $this->findPageKey($value, $requestArray, $currentIndex + 1, $idealRequestUriParts, $variables);
				}
				else
				{
					return array($idealRequestUriParts, $value, $variables);
				}
			}
			elseif(($key == '%d') && intval($currentUriPart) > 0 && is_numeric($currentUriPart))
			{
				/**
				 * цифра
				 */
				$idealRequestUriParts[] = $currentUriPart;

				if(is_array($value))
				{
					return $this->findPageKey($value, $requestArray, $currentIndex + 1, $idealRequestUriParts, $variables);
				}
				else
				{
					return array($idealRequestUriParts, $value, $variables);
				}
			}
			elseif($key == '%s' && $currentUriPart)
			{
				$idealRequestUriParts[] = $currentUriPart;

				if(is_array($value))
				{
					return $this->findPageKey($value, $requestArray, $currentIndex + 1, $idealRequestUriParts, $variables);
				}
				else
				{
					return array($idealRequestUriParts, $value, $variables);
				}
			}

		}

		if(isset($map['']))
		{
			return array($idealRequestUriParts, $map[''], $variables);
		}

		return array($idealRequestUriParts, false, $variables);
	}
}