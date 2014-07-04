<?php

class Html extends CHtml
{
    /**
     * @var string the HTML code to be prepended to the required label.
     * @see label
     */
    public static $beforeRequiredLabel='<span class="required">*</span>';

    /**
     * @var string the HTML code to be appended to the required label.
     * @see label
     */
    public static $afterRequiredLabel='';

    /**
     * Displays the first validation error for a model attribute.
     * @param CModel the data model
     * @param string the attribute name
     * @param array additional HTML attributes to be rendered in the container div tag.
     * This parameter has been available since version 1.0.7.
     * @return string the error display. Empty if no errors are found.
     * @see CModel::getErrors
     * @see errorMessageCss
     */
    public static function error($model,$attribute,$htmlOptions=array())
    {
        $error=$model->getError($attribute);
        if($error!='')
        {
            if(!isset($htmlOptions['class']))
                $htmlOptions['class']=self::$errorMessageCss;
            return self::tag('span',$htmlOptions,$error);
        }
        else
            return '';
    }

    /**
     * Generates a label tag for a model attribute.
     * This is an enhanced version of {@link activeLabel}. It will render additional
     * CSS class and mark when the attribute is required.
     * In particular, it calls {@link CModel::isAttributeRequired} to determine
     * if the attribute is required.
     * If so, it will add a CSS class {@link CHtml::requiredCss} to the label,
     * and decorate the label with {@link CHtml::beforeRequiredLabel} and
     * {@link CHtml::afterRequiredLabel}.
     * @param CModel the data model
     * @param string the attribute
     * @param array additional HTML attributes.
     * @return string the generated label tag
     * @since 1.0.2
     */
    public static function activeLabelEx($model,$attribute,$htmlOptions=array())
    {
        $realAttribute=$attribute;
        self::resolveName($model,$attribute); // strip off square brackets if any
        $htmlOptions['required']=$model->isAttributeRequired($attribute);
        return self::activeLabel($model,$realAttribute,$htmlOptions);
    }

    public static function activeLabel($model,$attribute,$htmlOptions=array())
    {
        if(isset($htmlOptions['for']))
        {
            $for=$htmlOptions['for'];
            unset($htmlOptions['for']);
        }
        else
            $for=self::getIdByName(self::resolveName($model,$attribute));
        if(isset($htmlOptions['label']))
        {
            if(($label=$htmlOptions['label'])===false)
                return '';
            unset($htmlOptions['label']);
        }
        else
            $label=$model->getAttributeLabel($attribute);
        if($model->hasErrors($attribute))
            self::addErrorCss($htmlOptions);
        return self::label($label,$for,$htmlOptions);
    }

    public static function label($label,$for,$htmlOptions=array())
    {
        if($for===false)
            unset($htmlOptions['for']);
        else
            $htmlOptions['for']=$for;
        if(isset($htmlOptions['required']))
        {
            if($htmlOptions['required'])
            {
                if(isset($htmlOptions['class']))
                    $htmlOptions['class'].=' '.self::$requiredCss;
                else
                    $htmlOptions['class']=self::$requiredCss;
                $label=self::$beforeRequiredLabel.$label.self::$afterRequiredLabel;
            }
            unset($htmlOptions['required']);
        }
        return self::tag('label',$htmlOptions,$label.yii::t('basic','：'));
    }

    public static function activeCheckBoxList($model,$attribute,$data,$htmlOptions=array())
    {
        self::resolveNameID($model,$attribute,$htmlOptions);
        $selection=self::resolveValue($model,$attribute);
        if($model->hasErrors($attribute))
            self::addErrorCss($htmlOptions);
        $name=$htmlOptions['name'];
        unset($htmlOptions['name']);

        $hiddenOptions=isset($htmlOptions['id']) ? array('id'=>self::ID_PREFIX.$htmlOptions['id']) : array();
        return self::hiddenField($name,'',$hiddenOptions)
            . self::checkBoxList($name,$selection,$data,$htmlOptions);
    }

    /**
     * 修改Html结构
     */
    public static function checkBoxList($name,$select,$data,$htmlOptions=array())
    {
        $template=isset($htmlOptions['template'])?$htmlOptions['template']:'<span class="item_choose">{input} {label}</span>';
        $separator=isset($htmlOptions['separator'])?$htmlOptions['separator']:"<br/>\n";
        unset($htmlOptions['template'],$htmlOptions['separator']);

        if(substr($name,-2)!=='[]')
            $name.='[]';

        if(isset($htmlOptions['checkAll']))
        {
            $checkAllLabel=$htmlOptions['checkAll'];
            $checkAllLast=isset($htmlOptions['checkAllLast']) && $htmlOptions['checkAllLast'];
        }
        unset($htmlOptions['checkAll'],$htmlOptions['checkAllLast']);

        $labelOptions=isset($htmlOptions['labelOptions'])?$htmlOptions['labelOptions']:array();
        unset($htmlOptions['labelOptions']);

        $items=array();
        $baseID=self::getIdByName($name);
        $id=0;
        $checkAll=true;

        foreach($data as $value=>$label)
        {
            $checked=!is_array($select) && !strcmp($value,$select) || is_array($select) && in_array($value,$select);
            $checkAll=$checkAll && $checked;
            $htmlOptions['value']=$value;
            $htmlOptions['id']=$baseID.'_'.$id++;
            $option=self::checkBox($name,$checked,$htmlOptions);
            //加label，实现点label即选中checkbox
            $label = CHtml::label($label, $htmlOptions['id']);
            //$label=self::label($label,$htmlOptions['id'],$labelOptions);
            $items[]=strtr($template,array('{input}'=>$option,'{label}'=>$label));
        }

        if(isset($checkAllLabel))
        {
            $htmlOptions['value']=1;
            $htmlOptions['id']=$id=$baseID.'_all';
            $option=self::checkBox($id,$checkAll,$htmlOptions);
            //$label=self::label($checkAllLabel,$id,$labelOptions);
            $label = $checkAllLabel;
            $item=strtr($template,array('{input}'=>$option,'{label}'=>$label));
            if($checkAllLast)
                $items[]=$item;
            else
                array_unshift($items,$item);
            $name=strtr($name,array('['=>'\\[',']'=>'\\]'));
            $js=<<<EOD
jQuery('#$id').click(function() {
    jQuery("input[name='$name']").attr('checked', this.checked);
});
jQuery("input[name='$name']").click(function() {
    jQuery('#$id').attr('checked', !jQuery("input[name='$name']:not(:checked)").length);
});
jQuery('#$id').attr('checked', !jQuery("input[name='$name']:not(:checked)").length);
EOD;
            $cs=Yii::app()->getClientScript();
            $cs->registerCoreScript('jquery');
            $cs->registerScript($id,$js);
        }
        $separator = '';
        return implode($separator,$items);
    }

    public static function radioButtonList($name,$select,$data,$htmlOptions=array())
    {
        $template=isset($htmlOptions['template'])?$htmlOptions['template']:'<span class="item_choose">{input} {label}</span>';
        $separator=isset($htmlOptions['separator'])?$htmlOptions['separator']:"\n";
        unset($htmlOptions['template'],$htmlOptions['separator']);

        $labelOptions=isset($htmlOptions['labelOptions'])?$htmlOptions['labelOptions']:array();
        unset($htmlOptions['labelOptions']);

        $items=array();
        $baseID=self::getIdByName($name);
        $id=0;
        foreach($data as $value=>$label)
        {
            $checked=!strcmp($value,$select);
            $htmlOptions['value']=$value;
            $htmlOptions['id']=$baseID.'_'.$id++;
            $option=self::radioButton($name,$checked,$htmlOptions);
            //加label，实现点label即选中radio
            $label = CHtml::label($label, $htmlOptions['id']);
//            $label='<span>'.$label.'</span>';
            $items[]=strtr($template,array('{input}'=>$option,'{label}'=>$label));
        }
        $separator = '';
        return implode($separator,$items);
    }

    public static function activeRadioButtonList($model,$attribute,$data,$htmlOptions=array())
    {
        self::resolveNameID($model,$attribute,$htmlOptions);
        $selection=self::resolveValue($model,$attribute);
        if($model->hasErrors($attribute))
            self::addErrorCss($htmlOptions);
        $name=$htmlOptions['name'];
        unset($htmlOptions['name']);

        $hiddenOptions=isset($htmlOptions['id']) ? array('id'=>self::ID_PREFIX.$htmlOptions['id']) : array();
        return self::hiddenField($name,'',$hiddenOptions)
            . self::radioButtonList($name,$selection,$data,$htmlOptions);
    }

    /**
     *
     * 生成日期Table头Html
     *
     * @param integer $type 0:年 1:月 2:日
     * @param string $StartTime 格式:Y-m-d
     * @param string $EndTime 格式:Y-m-d
     * @param integer $isWholeTable 1:生成tr 0:不生成
     * @param integer $isTotal
     * @param integer $colspan
     * @param integer $UserFlag
     */
	public static function echoOutDateTable($type,$StartTime,$EndTime,$isWholeTable=0,$isTotal=0,$colspan=1,$UserFlag="")
	{
		$HTML = "";
		if(Allyes::isearly($StartTime,$EndTime))
		{
			$tmp = $StartTime;
			$StartTime = $EndTime;
			$EndTime = $tmp;
		}

		while(!Allyes::isearly($StartTime,Allyes::getnextday($EndTime)))
		{
			$mktime = Allyes::mktimeOfDate($StartTime);
			$TimeArray = explode("-",$StartTime);
			$DateTableArray[$TimeArray[0]][$TimeArray[1]][$TimeArray[2]] = date("l",$mktime);

			$StartTime = Allyes::getnextday($StartTime);
		}

		if($isWholeTable==1)
			$HTML .= "<tr bgcolor=\"#FFFFFF\" valign=\"top\">\n";

		$tmp_rowspan = ($UserFlag=="MediaSearch_SetDay")?2:1;

		switch($type)
		{
			case 0://年
				foreach($DateTableArray as $keyYear=>$valueYear)
				{
					$HTML .= "<td bgcolor='#FFFFFF' align='left' colspan=\"".$colspan."\"><u style=\"color: #B5B2B5\"><span style=\"color: #000000\">".$keyYear."年</span></u></td>\n";
				}
				if($isTotal==1)
					$HTML .= "<td bgcolor='#FFFFFF' align='left' rowspan='$' nowrap><u style=\"color: #B5B2B5\" rowspan=\"1\"><span style=\"color: #000000\" >^小计^</span></u></td>\n";
				$HTML .= "</tr>\n";
				break;
			case 1://月
				foreach($DateTableArray as $keyYear=>$valueYear)
				{
					$HTML .= "<td colspan='".(sizeof($valueYear)*$colspan)."' bgcolor='#FFFFFF' align='left'><u style=\"color: #B5B2B5\"><span style=\"color: #000000\">".$keyYear."</span></u></td>\n";
				}
				if($isTotal==1)
					$HTML .= "<td bgcolor='#FFFFFF' align='left' nowrap><u style=\"color: #B5B2B5\" rowspan=\"2\"><span style=\"color: #000000\" >^小计^</span></u></td>\n";
				$HTML .= "</tr>\n";
				$HTML .= "<tr align=\"center\" class=\"workday\">\n";
				foreach($DateTableArray as $keyYear=>$valueYear)
					foreach($valueYear as $keyMonth=>$valueMonth)
					{
						$Color = "aftercurtime";
						$HTML .= "<td class='".$Color."' colspan=\"".$colspan."\">".$keyMonth."</td>";
					}
				$HTML .= "</tr>\n";
				break;
			case 2://日
				foreach($DateTableArray as $keyYear=>$valueYear)
				{
					foreach($valueYear as $keyMonth=>$valueMonth)
					{
						$HTML .= "<td colspan='".(sizeof($valueMonth)*$colspan)."' bgcolor='#FFFFFF' align='left' nowrap><u style=\"color: #B5B2B5\"><span style=\"color: #000000\">".$keyYear."-".$keyMonth."</span></u></td>\n";
					}
				}
				if($isTotal==1)
					$HTML .= "<td bgcolor='#FFFFFF' align='left' colspan='$tmp_rowspan' nowrap><u style=\"color: #B5B2B5\" rowspan=\"2\"><span style=\"color: #000000\" >^小计^</span></u></td>\n";
				$HTML .= "</tr>\n";
				$HTML .= "<tr align=\"center\" class=\"workday\">\n";
				foreach($DateTableArray as $keyYear=>$valueYear)
					foreach($valueYear as $keyMonth=>$valueMonth)
						foreach($valueMonth as $keyDay=>$valueDay)
						{
//							$fontColor = "#000000";
							$Color = ($valueDay=="Saturday" || $valueDay == "Sunday")?"beforcurwd":"beforcurday";
							//if ($keyYear."-".$keyMonth."-".$keyDay<date("Y-m-d"))
								$HTML .= "<td colspan=\"".$colspan."\" nowrap class=\"".$Color."\"><b>".$keyDay."</b></td>\n";
							//else
								//$HTML .= "<td class='$' colspan=\"".$colspan."\" nowrap><b>".$keyDay."</b></td>\n";
						}
				$HTML .= "</tr>\n";
				switch ($UserFlag)
				{
					case "MediaSearch_SetDay":
						$HTML .= "<tr align=\"center\" class=\"workday\">\n";
						foreach($DateTableArray as $keyYear=>$valueYear)
							foreach($valueYear as $keyMonth=>$valueMonth)
								foreach($valueMonth as $keyDay=>$valueDay)
								{
									$HTML .= "<td bgcolor='#CCCCCC' nowrap>^数量^</td><td bgcolor='aliceblue' nowrap>^投放量^</td>\n";
								}
						$HTML .= "</tr>\n";
						break;
					default:
						break;
				}
			break;
		}
		return $HTML;
	}

	/**
	 *
	 * 显示星星图示
	 * @param integer $num 星星数量
	 * @return html $HTML 星星图片
	 */
	public static function Star($num){
		$HTML = '';
		for($i=1;$i<=$num;$i++){
			$HTML .= parent::image(Yii::app()->baseUrl."/images/star.gif");
		}
		return $HTML;
	}

	/**
	 * 弹出框显示
	 * @param string $title
	 * @param string $message
	 * @param integer $id
	 */
	public static function Dialog ($title, $message, $id = 0) {
        if($id == 0)
            $id = rand(1, 999999);
        Yii::app()->user->setflash($id, array('title' => $title, 'content' => $message) );
    }

	/**
	 * 总库存报表table专用样式
	 * @param string $StartTime
	 */
	public static function echoSystemTable($StartTime,$EndTime)
	{
		$HTML = "";

		$HTML = "<tr><td align=\"center\" height=\"20\" width=\"80\" rowspan=\"3\">频道</td>";
        $HTML .= "<td align=\"center\" height=\"20\" width=\"80\" rowspan=\"3\">广告位</td>";
		$HTML .= "<td align=\"center\" height=\"20\" width=\"20\" rowspan=\"3\"><span id=\"pre_time\" time=\"".$StartTime."\">".CHtml::image(Yii::app()->baseUrl.'/images/t_l.gif')."</span></td>";
		$tmpStarTimeA = $StartTime;
		$dateColspanAry = array();
		while(!Allyes::isearly($tmpStarTimeA,Allyes::getnextday($EndTime))){
			$tempDateAry = explode("-",$tmpStarTimeA);
			$dateColspanAry[$tempDateAry[0]."-".$tempDateAry[1]][] = $tmpStarTimeA;

			$tmpStarTimeA = Allyes::getnextday($tmpStarTimeA);
		}

		foreach($dateColspanAry as $k=>$v){
			$HTML .= "<td align=\"center\" height=\"20\" colspan='".count($dateColspanAry[$k])."'>".$k."</td>";
		}
		$HTML .= "<td align=\"center\" height=\"20\" width=\"20\" rowspan=\"3\"><span id=\"nex_time\" time=\"".$StartTime."\">".CHtml::image(Yii::app()->baseUrl.'/images/t_r.gif')."</span></td></tr><tr>";
		$aryWeekDay = array('日','一','二','三','四','五','六');
		$tmpStarTime = $StartTime;
		while(!Allyes::isearly($tmpStarTime,Allyes::getnextday($EndTime))){
			$dateArr = explode("-", $tmpStarTime);
			$strWeekDay = date("w", mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]));
			$HTML .= "<td align=\"center\" height=\"20\">".$aryWeekDay[$strWeekDay]."</td>";

			$tmpStarTime = Allyes::getnextday($tmpStarTime);
		}
		$HTML .= "</tr><tr>";
		$tmpStarTime1 = $StartTime;
		while(!Allyes::isearly($tmpStarTime1,Allyes::getnextday($EndTime))){
			$dateArr = explode("-", $tmpStarTime1);
			$strWeekDay = date("w", mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]));
			if($strWeekDay==0 || $strWeekDay==6)
				$HTML .= "<td calss='beforcurwd'>".$dateArr[2]."</td>";
			else
				$HTML .= "<td calss='beforcurday'>".$dateArr[2]."</td>";

			$tmpStarTime1 = Allyes::getnextday($tmpStarTime1);
		}

		$HTML .= "</tr>\n";

		return $HTML;
	}

	/**
	 *
	 * 生成AJAX BUTTON
	 * @param string $label
	 * @param array $url
	 * @param array $ajaxOptions
	 * @param array $htmlOptions
	 */
    public static function ajaxSubmitButton($label,$url,$ajaxOptions=array(),$htmlOptions=array())
    {
        if(!isset($htmlOptions['type'])){
            $htmlOptions['type'] ='submit';
        }
        return self::ajaxButton($label,$url,$ajaxOptions,$htmlOptions);
    }
}