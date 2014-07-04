<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	/**
	 * @var string 用户名
	 */
    public $username;
    
    /**
     * @var string 密码
     */
    public $password;
    
    /**
     * @var boolean 密码保存
     */
//    public $rememberMe;
    
    /**
     * @var String 验证码
     */
    public $verifyCode;
    
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('username, password, verifyCode', 'safe'),
            // rememberMe needs to be a boolean
//            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
            array('verifyCode', 'activeCaptcha', 'on' => 'login', 'allowEmpty'=> !extension_loaded('gd')),
//            array('verifyCode', 'captcha', 'on'=>'login', 'allowEmpty'=> !extension_loaded('gd')),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'username' => Yii::t('basic','用户名'),
            'password' => Yii::t('basic','密码'),
            'verifyCode' => Yii::t('basic','验证码'),
        	'rememberMe'=> Yii::t('basic','保持登录登录'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params)
    {
        $session = Yii::app()->session;
            $this->_identity = new UserIdentity($this->username,$this->password);
            if(!$this->_identity->authenticate()){
                $this->addError('password',Yii::t('basic', '用户名或密码不正确.'));
            }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if($this->_identity===null){
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode === UserIdentity::ERROR_NONE){
			Yii::app()->user->login($this->_identity);
            return true;
        }
        else{
            return false;
        }
            
    }
    
    /**
     * 判断验证码
     * 
     */
    public function activeCaptcha() {
        $code = Yii::app()->controller->createAction('captcha')->getVerifyCode();
        if ($code != $this->verifyCode)
            $this->addError('verifyCode', Yii::t('basic', '验证码不正确.'));
        if (!(isset($_POST['ajax']) && $_POST['ajax']==='user-form'))
            Yii::app()->controller->createAction('captcha')->getVerifyCode(true);
    }
}
