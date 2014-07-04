<?php

/**
 * 分类表 "tb_user" AR模型.
 *
 * 包含字段:
 * @property string $ID 主键
 * @property string $Name 名称
 * @property string $Password 密码
 */
class Tb_user extends ActiveRecord
{
	public $passwordConfirm;
	/**
	 * Returns the static model of the specified AR class.
	 * @return channelPool the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string 表名，区分大小写
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * 预定义验证器类别名
	 *
	 * boolean: CBooleanValidator 的别名， 确保特性有一个 CBooleanValidator::trueValue 或 CBooleanValidator::falseValue 值。
     * captcha: CCaptchaValidator 的别名，确保特性值等于 CAPTCHA 中显示的验证码。
     * compare: CCompareValidator 的别名，确保特性等于另一个特性或常量。
     * email: CEmailValidator 的别名，确保特性是一个有效的Email地址。
     * default: CDefaultValueValidator 的别名，指定特性的默认值。
     * exist: CExistValidator 的别名，确保特性值可以在指定表的列中可以找到。
     * file: CFileValidator 的别名，确保特性含有一个上传文件的名字。
     * filter: CFilterValidator 的别名，通过一个过滤器改变此特性。
     * in: CRangeValidator 的别名，确保数据在一个预先指定的值的范围之内。
     * length: CStringValidator 的别名，确保数据的长度在一个指定的范围之内。
     * match: CRegularExpressionValidator 的别名，确保数据可以匹配一个正则表达式。
     * numerical: CNumberValidator 的别名，确保数据是一个有效的数字。
     * required: CRequiredValidator 的别名，确保特性不为空。
     * type: CTypeValidator 的别名，确保特性是指定的数据类型。
     * unique: CUniqueValidator 的别名，确保数据在数据表的列中是唯一的。
     * url: CUrlValidator 的别名，确保数据是一个有效的 URL。
     * safe: 安全字段
     *
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array_merge(parent::rules(), array(
            array('username,password,passwordConfirm', 'required', 'on'=>'create, update'),
			array('username', 'unique'), //唯一
			array('passwordConfirm', 'compare', 'compareAttribute' => 'password', 'on'=>'create, update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password', 'safe', 'on'=>'search'),
		));
	}

	/**
	 * 关联模型，所有关联的model首字母大小，STAT首字母小写
	 *
	 * 包含关系
	 * BELONGS_TO（属于）: 如果表 A 和 B 之间的关系是一对多，则 表 B 属于 表 A ;
	 * HAS_MANY（有多个）: 如果表 A 和 B 之间的关系是一对多，则 A 有多个 B ;
	 * HAS_ONE（有一个）: 这是 HAS_MANY 的一个特例，A 最多有一个 B ;
	 * MANY_MANY: 这个对应于数据库中的 多对多 关系;
	 * STAT: 作为一个属性值，一般求COUNT SUM AVG等值保存
	 *
	 * @return array 关联规则
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'username' => Yii::t('basic','用户名称'),
			'password' => Yii::t('basic', '密码'),
			'passwordConfirm' => Yii::t('basic', '确认密码'),
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        if($this->key != ''){
            $criteriaKey=new CDbCriteria;
			$criteriaKey->compare('t.id',$this->key,true, 'OR');
            $criteriaKey->compare('t.username',$this->key,true, 'OR');
            $criteria->mergeWith($criteriaKey, TRUE);
        }
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.username',$this->username,true);
		return new CActiveDataProvider('Tb_user', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
                'pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['perPage']),
            ),
            'sort'=>array(
                'defaultOrder'=>'t.id DESC',
            )
		));
	}

	/**
	 * 回调函数，所有find操作后，执行代码
	 * @see protected/libs/db/ar/CActiveRecord::afterFind()
	 */
	protected function afterFind(){
	}

	/**
     * 回调函数，保存前，执行代码
     * @see protected/libs/base/CModel::beforeSave()
     */
    protected function beforeSave(){
		return true;
    }
}