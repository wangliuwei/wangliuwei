<?php

class TCHttpRequest extends CHttpRequest {
	private $_requestUri;
	private $_pathInfo;
	private $_scriptFile;
	private $_scriptUrl;
	private $_hostInfo;
	private $_url;
	private $_baseUrl;
	private $_cookies;
	private $_preferredLanguage;
	private $_csrfToken;

	private $_securePort;

	private $_port;

	public function getPathInfo() {
		if ($this->_pathInfo === null) {
			$pathInfo = $this->getRequestUri ();

			if (($pos = strpos ( $pathInfo, '?' )) !== false)
				$pathInfo = substr ( $pathInfo, 0, $pos );

			$pathInfo = urldecode ( $pathInfo );

			$scriptUrl = $this->getScriptUrl ();
			$baseUrl = $this->getBaseUrl ();
			if (strpos ( $pathInfo, $scriptUrl ) === 0)
				$pathInfo = substr ( $pathInfo, strlen ( $scriptUrl ) );
			else if ($baseUrl === '' || strpos ( $pathInfo, $baseUrl ) === 0)
				$pathInfo = substr ( $pathInfo, strlen ( $baseUrl ) );
			else if (strpos ( $_SERVER ['PHP_SELF'], $scriptUrl ) === 0)
				$pathInfo = substr ( $_SERVER ['PHP_SELF'], strlen ( $scriptUrl ) );
			else
				throw new CException ( Yii::t ( 'yii', 'CHttpRequest is unable to determine the path info of the request.' ) );

		//hack 删除前面的数据库配置文件名,例如imedia_dev
			$pathInfo = preg_replace ( '/^\/.*?\//', '', $pathInfo );

			$this->_pathInfo = trim ( $pathInfo, '/' );
		}
		return $this->_pathInfo;
	}
}
?>