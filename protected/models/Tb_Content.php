<?php

/**
 * This is the model class for table "{{content}}".
 *
 * The followings are the available columns in table '{{content}}':
 * @property integer $id
 * @property string $title
 * @property string $subTitle
 * @property integer $type
 * @property string $path
 * @property string $url
 * @property integer $categoryID
 * @property integer $position
 * @property integer $priority
 * @property integer $showIndex
 * @property integer $showNum
 * @property integer $disable
 * @property string $createDate
 * @property string $updateDate
 */
class Tb_Content extends ActiveRecord
{
    public $type = 1;
    
    public $showIndex = 0;
    
    public $showAuthor = 0;
    
    public $showCategory = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tb_Content the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{content}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, subTitle, type, categoryID, priority', 'required'),
			array('type, categoryID, position, priority, showIndex, disable,showAuthor,showCategory', 'numerical', 'integerOnly'=>true),
			array('title, subTitle', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, subTitle, type, path, url, categoryID, position, priority, showIndex,showAuthor,showCategory,disable, createDate, updateDate,jumpUrl,showImage', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
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
		return array(
			'id' => 'ID',
			'title' => '标题',
			'subTitle' => '子标题',
			'type' => '类型',
			'path' => '上传图片',
			'url' => '链接',
            'jumpUrl' => '跳转链接',
			'categoryID' => '分类',
			'position' => '位置',
			'priority' => '排序',
			'showIndex' => '显示首页',
            'showAuthor' => '显示分类首页',
            'showCategory' => '显示作者首页',
			//'showNum' => '显示数量',
			'disable' => '状态',
			'createDate' => 'Create Date',
			'updateDate' => 'Update Date',
		);
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
            $criteriaKey->compare('t.title',$this->key,true, 'OR');
            $criteria->mergeWith($criteriaKey, TRUE);
        }
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('subTitle',$this->subTitle,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('categoryID',$this->categoryID);
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		    'pagination'=>array(
                'pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['perPage']),
            ),
            'sort'=>array(
                'defaultOrder'=>'t.id DESC',
            )
		));
	}
}