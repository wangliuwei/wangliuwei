<?php

/**
 * 继承CURLMANAGER 重写 url 生成
 * */
class UrlManager extends CUrlManager {
    /**
     * @var string 数据库配置文件名
     */
    public $dbConfigName = '';

    private $_urlFormat = self::GET_FORMAT;
    private $_rules = array ();
    private $_baseUrl;

    //初始化UrlManager调用
    public function init() {
        parent::init ();

        $routes = $_SERVER ['REQUEST_URI'];
        $routes = str_replace ( $this->getBaseUrl () . '/', '', $routes );
        $arrayRoutes = explode ( '/', $routes );
        $this->dbConfigName = $arrayRoutes [0];
    }

    //重写url
    public function createUrl($route, $params = array(), $ampersand = '&') {
        unset ( $params [$this->routeVar] );
        foreach ( $params as &$param )
            if ($param === null)
                $param = '';
        if (isset ( $params ['#'] )) {
            $anchor = '#' . $params ['#'];
            unset ( $params ['#'] );
        } else
            $anchor = '';
        $route = trim ( $route, '/' );
        //hack 所有生成链接增加db配置名
        /*
         $routes = $_SERVER['REQUEST_URI'];
        $routes = str_replace($this->_baseUrl.'/', '', $routes);
        $arrayRoutes = explode('/', $routes);
        $route = $arrayRoutes[0].'/'.$route;
        */
        $route = $this->dbConfigName . '/' . $route;
        foreach ( $this->_rules as $rule ) {
            if (($url = $rule->createUrl ( $this, $route, $params, $ampersand )) !== false) {
                if ($rule->hasHostInfo)
                    return $url === '' ? '/' . $anchor : $url . $anchor;
                else
                    return $this->getBaseUrl () . '/' . $url . $anchor;
            }
        }

        return $this->createUrlDefault ( $route, $params, $ampersand ) . $anchor;
    }
    public function getCookieKey($key){
        return md5(strtolower($this -> dbConfigName.':'.$key));
    }
}