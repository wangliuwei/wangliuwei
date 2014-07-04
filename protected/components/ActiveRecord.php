<?php
/**
 *
 * 所有models的基类
 *
 * 继承CActiveRecord
 * @author kid
 * @package components
 */
class ActiveRecord extends CActiveRecord
{
    /**
     * 关键字
     * @var String
     */
    public $key = '';

    /**
     * 有效性选择
     * @var array
     */
    public $optDisable = array();

    /**
     * @var array 字符编码集合，从以下代码集合中查询字符编码
     */
    public $codeSet = array('GB2312','GBK', 'UTF-8');

    /**
     * @var array 字符编码结果集合，mb_detect_encoding后匹配以下编码集
     */
    public $codeResultSet = array('CP936','EUC-CN');

	public $beforeCodeSet = array('UTF-8','GB2312','GBK');

	public $beforeCodeResultSet = array('UTF-8','CP936','EUC-CN');
    /**
     * @var integer old primary key value
     */
    private $_pk;

    public function init()
    {
        $this->setOptDisableValue();
    }

    /**
     * 设置key值，默认为安全
     */
    public function rules()
    {
        return array(
        	array('id', 'length','max'=>'32'),
            array('key', 'length','max'=>'255'),
        );
    }
    /**
     * 设置默认值
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('basic', 'ID'),
            'key' => yii::t('basic','关键字'),
        );
    }

    /**
     * 初始化disable的值
     */
    public function setOptDisableValue(){
        return $this->optDisable = array(
//            0 => yii::t('basic','是'),
//            1 => yii::t('basic','否'),
            0 => yii::t('basic','有效'),
            1 => yii::t('basic','无效'),
        );
    }

    /**
     * 初始化disable的值
     */
    public function getDisableValue($key){
        return $this->optDisable[$key];
    }

    /**
     * Returns the database connection used by active record.
     * By default, the "db" application component is used as the database connection.
     * You may override this method if you want to use a different database connection.
     * @return CDbConnection the database connection used by active record.
     */
    public function getDbConnection()
    {
//        Yii::app()->db->setActive(false);
//        if(!strstr(Yii::app()->getDb()->connectionString, 'dbname=')){
//            $session = Yii::app()->session;
//            $arrStr = 'dbname='. $session['mms_connectDb'];
//            Yii::app()->getDb()->connectionString = Yii::app()->getDb()->connectionString.$arrStr;
//        }
//        echo  Yii::app()->getDb()->connectionString;
//        Yii::app()->db->setActive(true);

        if(self::$db!==null)
            return self::$db;
        else
        {
            self::$db=Yii::app()->getDb();
            if(self::$db instanceof CDbConnection)
            {
                self::$db->setActive(true);
                return self::$db;
            }
            else
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }

    /**
     * 生成model的查看链接
     */
    public function getUrl()
    {
        $controller=get_class($this);
        $controller[0]=strtolower($controller[0]);
        $params=array('ID'=>$this->id);
        if($this->hasAttribute('title'))
            $params['title']=$this->title;
        return Yii::app()->urlManager->createUrl($controller.'/view', $params);
    }

    /**
     * 正则表达式
     */
//    public function setZhengZhe($ItemType_Text)
//    {
//        $ItemType_Text=preg_replace("/\_/","\\_",$ItemType_Text);
//        $ItemType_Text=preg_replace("/\*/","%",$ItemType_Text);
//        $ItemType_Text=preg_replace("/\?/","_",$ItemType_Text);
//        return $ItemType_Text;
//    }

    /**
     * 初始化disable的值
     */
    public function getIsValue($key){
        $options = array(
            0 => Yii::t('basic', '否'),
            1 => Yii::t('basic', '是')
        );
        return $options[$key];
    }
	 /**
	 * Saves the current record.
	 *
	 * The record is inserted as a row into the database table if its {@link isNewRecord}
	 * property is true (usually the case when the record is created using the 'new'
	 * operator). Otherwise, it will be used to update the corresponding row in the table
	 * (usually the case if the record is obtained using one of those 'find' methods.)
	 *
	 * Validation will be performed before saving the record. If the validation fails,
	 * the record will not be saved. You can call {@link getErrors()} to retrieve the
	 * validation errors.
	 *
	 * If the record is saved via insertion, its {@link isNewRecord} property will be
	 * set false, and its {@link scenario} property will be set to be 'update'.
	 * And if its primary key is auto-incremental and is not set before insertion,
	 * the primary key will be populated with the automatically generated key value.
	 *
	 * @param boolean $runValidation whether to perform validation before saving the record.
	 * If the validation fails, the record will not be saved to database.
	 * @param array $attributes list of attributes that need to be saved. Defaults to null,
	 * meaning all attributes that are loaded from DB will be saved.
	 * @return boolean whether the saving succeeds
	 */
	public function save($runValidation=true,$attributes=null)
	{
                $validate_flag = $this->validate($attributes);

                if(!$runValidation || $validate_flag)
			return $this->getIsNewRecord() ? $this->insert($attributes) : $this->update($attributes);
		else
                {
                        return false;
                }

	}
        /**
	 * Inserts a row into the table based on this active record attributes.
	 * If the table's primary key is auto-incremental and is null before insertion,
	 * it will be populated with the actual value after insertion.
	 * Note, validation is not performed in this method. You may call {@link validate} to perform the validation.
	 * After the record is inserted to DB successfully, its {@link isNewRecord} property will be set false,
	 * and its {@link scenario} property will be set to be 'update'.
	 * @param array $attributes list of attributes that need to be saved. Defaults to null,
	 * meaning all attributes that are loaded from DB will be saved.
	 * @return boolean whether the attributes are valid and the record is inserted successfully.
	 * @throws CException if the record is not new
	 */
	public function insert($attributes=null)
	{
		if(!$this->getIsNewRecord())
			throw new CDbException(Yii::t('yii','The active record cannot be inserted to database because it is not new.'));
		if($this->beforeSave())
		{
			Yii::trace(get_class($this).'.insert()','system.db.ar.CActiveRecord');
			$builder=$this->getCommandBuilder();
			$table=$this->getMetaData()->tableSchema;
			$command=$builder->createInsertCommand($table,$this->getAttributes($attributes));
			if($command->execute())
			{
				$primaryKey=$table->primaryKey;

				if($table->sequenceName!==null)
				{
					if(is_string($primaryKey) && ($this->$primaryKey===null || $this->$primaryKey===''))
						$this->$primaryKey=$builder->getLastInsertID($table);
					else if(is_array($primaryKey))
					{
						foreach($primaryKey as $pk)
						{
							if($this->$pk===null)
							{
								$this->$pk=$builder->getLastInsertID($table);
								break;
							}
						}
					}
				}
				$this->_pk=$this->getPrimaryKey();
				$this->afterSave();
				$this->setIsNewRecord(false);
				$this->setScenario('update');
				return true;
			}
		}
		return false;
	}

    public function AlleysError()
    {
        $orgErrors = $this->getErrors();
        $ajaxErros = array(
            'result'=>1,
            'data'=>$orgErrors
        );
        return $ajaxErros;
    }

    public function validate($attributes=null)
    {
        $this->clearErrors();
        if($this->beforeValidate())
        {
            foreach($this->getValidators() as $validator)
            $validator->validate($this,$attributes);
            $this->afterValidate();

            return !$this->hasErrors();
        }
        else
            return false;
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    //验证字母,下划线,数字
    public function checkCode($attribute,$params)
    {
		$re = preg_match("/^[a-zA-Z\d_]+$/",$this->$attribute);
		if(!$re){

                        $this->addError($attribute,Yii::t('basic', '标识中含有非法字符'));
		}else{
			return true;
		}
    }

    //允许字母，下划线，中英文，数字
    public function checkCodeEx($attribute,$params)
    {
		$re = preg_match("/[\u4e00-\u9fa5a-z][\u4e00-\u9fa5a-z0-9_]*$/",$this->$attribute);
		if(!$re){
			$this->addError($attribute,Yii::t('basic', '标识中含有非法字符'));
		}else{
			return true;
		}
    }

    //字母,下划线,数字或中文
    public function checkTitle($attribute,$params)
    {
		if($this->$attribute !='')
		{
			$re = preg_match("/[a-zA-Z0-9_\x80-\xff]+$/",$this->$attribute);
			if(!$re)
			{
				$this->addError($attribute,Yii::t('basic', '名称中含有非法字符'));
			}
			else
			{
				return true;
			}
		}
    }

    public function unique($attribute,$params){
    	if($this->isAttributeRequired($attribute) && $this->isEmpty($this->$attribute))
			return;
        $criteria = array();
    	$value=$this->$attribute;
    	if(!is_array($value) && self::isUtf8($value)){
            $value = iconv('utf-8','gbk',$value);
        }
    	$criteria=new CDbCriteria(array(
			'condition'=>"$attribute=:value",
			'params'=>array(':value'=>$value),
		));
		if (isset($this->GID) && $this->GID==0)
			$criteria->addCondition('t.GID =0');
		else
			return true;
	    if (isset($this->GID))
                $criteria->addCondition('GID = 0');

		$table=$this->getTableSchema();
                if (isset($this->GID)) $criteria->addCondition('t.GID = 0');
		if(($column=$table->getColumn($attribute))===null)
			throw new CException(Yii::t('yii','Table "{table}" does not have a column named "{column}".',
				array('{column}'=>$attribute,'{table}'=>$table->name)));

		$columnName=$column->rawName;
		if($criteria!==array())
			$criteria->mergeWith($criteria);

		if($this->isNewRecord){
//			var_dump($criteria);Yii::app()->end();
			$exists=$this->exists($criteria);
		}
		else
		{

			$criteria->limit=2;
			$objects=$this->findAll($criteria);
			$n=count($objects);
			if($n===1)
			{
				if($column->isPrimaryKey)  // primary key is modified and not unique
					$exists=$this->getOldPrimaryKey()!=$this->getPrimaryKey();
				else // non-primary key, need to exclude the current record based on PK

					$exists=$objects[0]->getPrimaryKey()!=$this->getOldPrimaryKey();
			}
			else
				$exists=$n>1;
		}



//		$className=$this->className===null?get_class($object):Yii::import($this->className);
//		$attributeName=$this->attributeName===null?$attribute:$this->attributeName;
//		$finder=CActiveRecord::model($className);
//		$table=$finder->getTableSchema();
//		if(($column=$table->getColumn($attributeName))===null)
//			throw new CException(Yii::t('yii','Table "{table}" does not have a column named "{column}".',
//				array('{column}'=>$attributeName,'{table}'=>$table->name)));
//
//		$columnName=$column->rawName;
//		$criteria=new CDbCriteria(array(
//			'condition'=>$this->caseSensitive ? "$columnName=:value" : "LOWER($columnName)=LOWER(:value)",
//			'params'=>array(':value'=>$value),
//		));
//		if($this->criteria!==array())
//			$criteria->mergeWith($this->criteria);
//
//		if(!$object instanceof CActiveRecord || $object->isNewRecord || $object->tableName()!==$finder->tableName())
//			$exists=$finder->exists($criteria);
//		else
//		{
//			$criteria->limit=2;
//			$objects=$finder->findAll($criteria);
//			$n=count($objects);
//			if($n===1)
//			{
//				if($column->isPrimaryKey)  // primary key is modified and not unique
//					$exists=$object->getOldPrimaryKey()!=$object->getPrimaryKey();
//				else // non-primary key, need to exclude the current record based on PK
//					$exists=$objects[0]->getPrimaryKey()!=$object->getOldPrimaryKey();
//			}
//			else
//				$exists=$n>1;
//		}

		if($exists)
		{
//			$this->addError($object,$attribute,$message,array('{value}'=>$value));

            $attributesName = $this->getAttributeLabel($attribute);
            $message=(isset($params['message'])&&$params['message']!==null)?$params['message']:Yii::t('basic','{attribute} "{value}" 已存在.',array('{attribute}'=>$attributesName,'{value}'=>$this->$attribute));
                    $this->addError($attribute,Yii::t('basic', $message));
		}
    }

	/**
	 * Checks if the given value is empty.
	 * A value is considered empty if it is null, an empty array, or the trimmed result is an empty string.
	 * Note that this method is different from PHP empty(). It will return false when the value is 0.
	 * @param mixed $value the value to be checked
	 * @param boolean $trim whether to perform trimming before checking if the string is empty. Defaults to false.
	 * @return boolean whether the value is empty
	 * @since 1.0.9
	 */
	protected function isEmpty($value,$trim=false)
	{
		return $value===null || $value===array() || $value==='' || $trim && is_scalar($value) && trim($value)==='';
	}

	public function existAdvertiser($attribute,$params){
		$value=$this->$attribute;
		if($value <= 0){
			$result = false;
		}
		$model = Advertiser::model()->findByAttributes(array(
			'ID' => $value
		));
		if($model != ''){
			$result = true;
		}else{
			$result = false;
		}

		if($result){
			return true;
		}else{
			$this->addError($attribute, Allyes::t('basic', '广告主不存在'));
		}
	}

	/**
	 * 获得字符编码
	 * @param string $str 字符串
	 * @param string 字符编码
	 */
	public function getStringCode($str){
		if(mb_detect_encoding($str, "utf-8") && mb_detect_encoding($str, "gbk")){
			return "utf-8";
		}else{
			return "gbk";
		}
	}

	/**
	 * 判断字符串是否为utf8
	 * @param sring $str 字符串
	 */
	public function isUtf8($value){
//		$code = self::getStringCode($str);
//		if($code == 'utf-8'){
//			return true;
//		}else{
//			return false;
//		}
	    if(in_array(mb_detect_encoding($value,$this->beforeCodeSet),$this->beforeCodeResultSet)){
            return true;
        }else{
            return false;
        }
	}

	/**
	 * 判断字符串是否为gbk
	 * @param sring $str 字符串
	 */
	public function isGbk($value){
//		$code = self::getStringCode($str);
//		if($code == 'gbk'){
//			return true;
//		}else{
//			return false;
//		}
	   if(in_array(mb_detect_encoding($value,$this->codeSet),$this->codeResultSet)){
            return true;
        }else{
            return false;
        }
	}

	/**
	 * Finds the number of rows satisfying the specified query condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return string the number of rows satisfying the specified query condition. Note: type is string to keep max. precision.
	 */
	public function count($condition='',$params=array())
	{

		Yii::trace(get_class($this).'.count()','system.db.ar.CActiveRecord');
		$builder=$this->getCommandBuilder();
		$criteria=$builder->createCriteria($condition,$params);
		$this->applyScopes($criteria);

		if(empty($criteria->with))
			return $builder->createCountCommand($this->getTableSchema(),$criteria)->queryScalar();
		else
		{
			$finder=new ActiveFinder($this,$criteria->with);
			return $finder->count($criteria);
		}
	}
}
?>