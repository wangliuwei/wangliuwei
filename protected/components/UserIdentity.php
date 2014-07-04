<?php

/**
 * 用户身份类
 *
 * 包含验证方法和存取用户数据
 */
class UserIdentity extends CUserIdentity {
    
    /**
     * @var integer 账户过期
     */
    const PASSWORD_EXPIRED = 1;
    
    /**
     * @var integer 账户未过期
     */
    const PASSWORD_UNEXPIRED = 0;

    /**
     * @var integer 用户ID
     */
    private $_id;

    /**
     * 验证一个用户登录
     * @return boolean 是否验证
     */
    public function authenticate() {
        $session = Yii::app()->session;
        $connection = Yii::app()->getDb();
        $mUser = Tb_user::model()->findByAttributes(array(
            'username' => $this->username,
            'password' => md5($this->password),
        ));
        var_dump($this->username,md5($this->password));
        //用户名或密码错误
        if(!isset($mUser)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        //登陆成功
        else {
            $this->_id = $mUser->id;
            $this->username = $mUser->username;
            $this->errorCode = self::ERROR_NONE;
            $this->setState('username', $mUser->username);
            $this->setState('userid', $mUser->id);                
        }
        return $this->errorCode==self::ERROR_NONE;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId()
    {
        return $this->_id;
    }
}