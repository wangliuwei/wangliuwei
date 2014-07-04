<?php
/**
 * 自定义ActiveForm
 * 
 * 用于修改CActiveForm默认生成的Html代码
 * 
 * @author kid
 * @package components
 */
class ActiveForm extends CActiveForm
{
	private $_attributes=array();
	private $_summary;
	    
    /**
     * 修改为调用Html::error方法
     * @see protected/libs/web/widgets/CActiveForm::error()
     */
    public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true)
    {
        if(!$this->enableAjaxValidation || !$enableAjaxValidation)
            return Html::error($model,$attribute,$htmlOptions);

        $inputID=isset($htmlOptions['inputID']) ? $htmlOptions['inputID'] : CHtml::activeId($model,$attribute);
        unset($htmlOptions['inputID']);
        if(!isset($htmlOptions['id']))
            $htmlOptions['id']=$inputID.'_em_';

        $option=array('inputID'=>$inputID, 'errorID'=>$htmlOptions['id']);

        $optionNames=array(
            'validationDelay',
            'validateOnChange',
            'validateOnType',
            'hideErrorMessage',
            'inputContainer',
            'errorCssClass',
            'successCssClass',
            'validatingCssClass',
            'beforeValidateAttribute',
            'afterValidateAttribute',
        );
        foreach($optionNames as $name)
        {
            if(isset($htmlOptions[$name]))
            {
                $option[$name]=$htmlOptions[$name];
                unset($htmlOptions[$name]);
            }
        }
        if($model instanceof CActiveRecord && !$model->isNewRecord)
            $option['status']=1;

        if(!isset($htmlOptions['class']))
            $htmlOptions['class']=$this->errorMessageCssClass;
        $html=CHtml::error($model,$attribute,$htmlOptions);
        if($html==='')
        {
            if(isset($htmlOptions['style']))
                $htmlOptions['style']=rtrim($htmlOptions['style'],';').';display:none';
            else
                $htmlOptions['style']='display:none';
            $html=CHtml::tag('div',$htmlOptions,'');
        }

        $this->_attributes[$inputID]=$option;
        return $html;
    }
    
    /**
     * 修改为调用Html::activeLabelEx方法
     * @see components/libs/web/widgets/CActiveForm::labelEx()
     */
    public function labelEx($model,$attribute,$htmlOptions=array())
    {
        return Html::activeLabelEx($model,$attribute,$htmlOptions);
    }

    public function textField($model,$attribute,$htmlOptions=array())
    {
        if (isset($htmlOptions['_verify']))
        {
            $htmlOptions['_verify'] .= $this->getFormVerify($model,$attribute);
        }
        else
        {
            $htmlOptions['_verify'] = $this->getFormVerify($model,$attribute);
        }    
        return CHtml::activeTextField($model,$attribute,$htmlOptions);
    }
    
    public function hiddenField($model,$attribute,$htmlOptions=array())
    {
        if (isset($htmlOptions['_verify']))
        {
            $htmlOptions['_verify'] .= $this->getFormVerify($model,$attribute);
        }
        else
        {
            $htmlOptions['_verify'] = $this->getFormVerify($model,$attribute);
        }
        return CHtml::activeHiddenField($model,$attribute,$htmlOptions);
    }

    public function textArea($model,$attribute,$htmlOptions=array())
    {        
        if (isset($htmlOptions['_verify']))
        {
            $htmlOptions['_verify'] .= $this->getFormVerify($model,$attribute);
        }
        else
        {
            $htmlOptions['_verify'] = $this->getFormVerify($model,$attribute);
        }
        return CHtml::activeTextArea($model,$attribute,$htmlOptions);
    }
    
    /**
     * 修改为调用Html::activeCheckBoxList方法
     */
    public function checkBoxList($model,$attribute,$data,$htmlOptions=array())
    {
        if (isset($htmlOptions['_verify']))
        {
            $htmlOptions['_verify'] .= $this->getFormVerify($model,$attribute);
        }
        else
        {
            $htmlOptions['_verify'] = $this->getFormVerify($model,$attribute);
        }
        return Html::activeCheckBoxList($model,$attribute,$data,$htmlOptions);
    }
    
    public function dropDownList($model,$attribute,$data,$htmlOptions=array())
    {
	if (isset($htmlOptions['_verify']))
        {
            $htmlOptions['_verify'] .= $this->getFormVerify($model,$attribute);
        }
        else
        {
            $htmlOptions['_verify'] = $this->getFormVerify($model,$attribute);
        }
        return CHtml::activeDropDownList($model,$attribute,$data,$htmlOptions);
    }
    
    /**
     * 修改为调用Html::activeRadioButtonList方法
     * @see protected/libs/web/widgets/CActiveForm::radioButtonList()
     */
    public function radioButtonList($model,$attribute,$data,$htmlOptions=array())
    {
        if (isset($htmlOptions['_verify']))
        {
            $htmlOptions['_verify'] .= $this->getFormVerify($model,$attribute);
        }
        else
        {
            $htmlOptions['_verify'] = $this->getFormVerify($model,$attribute);
        }
        return Html::activeRadioButtonList($model,$attribute,$data,$htmlOptions);
    }
    

    
    private function getFormVerify($model,$attribute)
    {   
        $Validators = $model->getValidators($attribute);       
        $verifyString = '';

        foreach($Validators as $valiindex => $Validator)
        {             
            $className = get_class($Validator);
            switch ($className)
            {
                case 'CRequiredValidator': 
                    $verifyString.=' required';
                    break;
                case 'CNumberValidator':
                    $verifyString.=' number';
                    break;
                case 'CStringValidator':
                    if ($Validator->max)
                    {
                        $verifyString.=' maxlength:'.$Validator->max;
                    }
                    if ($Validator->min)
                    {
                        $verifyString.=' minlength:'.$Validator->min;
                    }
                    break;
                case 'CUrlValidator':
                    $verifyString.=' url';
                    break;
                case 'CEmailValidator':
                    $verifyString.=' email';
                    break;
                case 'CRegularExpressionValidator':
                    if ($Validator->pattern == '/^\d+(\.\d+)?$/')
                           $verifyString.=' floatnumber';
                    else if ($Validator->pattern == '/^[0-9]*[1-9][0-9]*$/')
                           $verifyString.=' digits'; 
                    else if ($Validator->pattern == '/^(?:[0-9]+|[0-9]{1,3}(?:,[0-9]{3})+)(?:\.[0-9]{2,2})?$/')
                           $verifyString.=' floatlimit:2'; 
                    break;

                case 'CInlineValidator':
                    switch ($Validator->method)
                    {
                        case 'checkCode':
                            $verifyString.=' allyesRuleA'; 
                            break;
                        case 'checkTitle':
                            $verifyString.=' allyesRuleB';
                            break;
                        case 'unique':
                            if ($model->isNewRecord)
                            {
                                $verifyString.=' remoteA:AjaxVerifyUnique';
                            }
                            else
                            {
                                $verifyString.=' remoteA:AjaxVerifyUnique updateRecord:'.$model->$attribute;
                            } 
                            break;
                    }
            }
        }
        return $verifyString;
    }
    
}