<?php
/**
 * blitz 引擎
 */
class BlitzView extends Blitz 
{
    public $time = '20150510001';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Assign variables to the template
     *
     * Allows setting a specific key to the specified value, OR passing
     * an array of key => value pairs to set en masse.
     *
     * @param   string|array    $spec   The assignment strategy to use
     * @param   mixed           $value  (Optional)
     * @return  void
     */
    public function assign($spec, $value = null)
    {
        if (is_array($spec))
        {
            $this->set($spec);
        }
        else if (null !== $value)
        {
            $this->set(array($spec => $value));
        }
    }

    /**
     * Processes a template and display the output.
     *
     * @param   string          $path
     * @param   string          $view_file
     * @param   array           $tpl_vars  (Optional)
     * @return  null || string
     */
    public function display($path,$view_file, $tpl_vars = null)
    {
        if (file_exists($path.$view_file))
        {
            $body = file_get_contents($path.$view_file);

            $this->load($body);
            if (is_array($tpl_vars))
            {
                $this->set($tpl_vars);
            }
            parent::display();
        }
    }
    public function displayContetnt($content, $tpl_vars = null)
    {
        //  return $content;
        $this->load($content);

       if (is_array($tpl_vars))
        {
           $this->set($tpl_vars);
        }
        return $this->parse();

    }

    public function cny($n) {

        $fraction = array('角','分');
        $digit = array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
        $unit =array(array('元', '萬', '亿'),array('', '拾', '佰', '仟'));
        $head = $n < 0 ? '欠': '';
        $n = abs($n);

        $s = '';

        for($i=0;$i<count($fraction);$i++){
            $s.=preg_replace('/^零.*/','',$digit[($n*10*pow(10,$i)%10)].$fraction[$i]);
        }
        $str='';
        for($i=0;$i<count($unit[0]) && $n>0;$i++){
            $p='';
            for($j=0;$j<count($unit[1]) && $n>0;$j++){
                $p=preg_replace('/(零.{3})+$/',' ',$digit[$n%10].$unit[1][$j]).$p;
                $n=floor($n/10);
            }
            $str=preg_replace('/零/','',$p).$unit[0][$i].$str;
        }
        return $head.preg_replace('/零元/','元',preg_replace('/\s+/','零',$str)).$s;
    }

    public function inclUrl($url="")
    {
        return file_get_contents("http://".$_SERVER['HTTP_HOST'].$url);
    }

    public function dateFormat($timestamp, $format = 'Y-m-d H:i:s')
    {
        return date($format, $timestamp);
    }

    public function loadCss($files)
    {
        $html = '';
        if (!empty($files))
        {
            $arr = explode(',', $files);
            foreach ($arr as $css)
            {
                $css = trim($css);
                if (!empty($css))
                {
                    $html .= "<link rel=\"stylesheet\" href=\"/static/css/{$css}.css?t={$this->time}\" type=\"text/css\" />\r\n";
                }
            }
        }
        return $html;
    }

    public function page($s_id, $curpage, $previousPage, $startPage, $endPage, $totalPage, $nextPage, $lastPage, $total, $s_ab)
    {
        $htm = '<li><a href="/'.$s_ab.'/1">首页</a></li>';

        if($curpage > 1)
        {
            $htm .= '<li><a href="/'.$s_ab.'/' . $previousPage . '/">上一页</a></li>';
        }

        for($i = $startPage; $i <= $endPage; $i++)
        {
            if( $i != $curpage )
            {
                $htm .= '<li><a href="/'.$s_ab.'/' . $i . '/">'. $i . '</a></li>';
            }else{
                $htm .= '<li class="page_hover">'. $i . '</li>';
            }

        }

        if($curpage < $totalPage)
        {
            $htm .= '<li><a href="/'.$s_ab.'/' . $nextPage . '/">下一页</a></li>';
        }

        $htm .= '<li><a href="/'.$s_ab.'/'. $lastPage .'/">末页</a></li>';

        $htm .= '<li><select name="page" onchange="pageJump(this.value)">';
        for($i=1; $i<=$totalPage; $i++)
        {
                $htm .= '<option value="'.$i.'"';
                if( $i == $curpage)
                {
                    $htm .= ' selected=selected';
                }
                $htm .= '>'.$i.'</option>';
        }
        $htm .= '</select></li>';

        $htm .= '<li><span class="pageinfo">共 <strong>' . $totalPage . '</strong>页<strong>' . $total . '</strong>条</span></li>';

        return $htm;
    }
    public function datetimeTodate($datetime='0000-00-00 00:00:00')
    {

        $ymd =  date('Y-m-d',strtotime($datetime));
        if($ymd=='1970-01-01'){
            return '0000-00-00';
        }else if($ymd=='-0001-11-30'){
            return '0000-00-00';
        }else{
            return $ymd;
        }
    }
    public function numformat($number)
    {
        if($number){
            return number_format($number, 2, '.', ',');
        }else{
            return '0.00';
        }
    }
    //四舍五入
    public function numround($number)
    {
        if($number){
            return round($number);
        }else{
            return '0';
        }
    }
    /**
    * $num 数字字符串
    * $s   数字开头显示的个数
    * $e   数字结尾显示的个数
    */
    public function hidecenternum($num,$s,$e)
    {
        if(!$num){
            return '';
        }
        $l =  mb_strlen($num,'UTF-8');
        $str1 = substr($num, 0,$s);
        $str2 = substr($num, -$e);
        if($l<($s+$e)){
            return '****';
        }
        $c = '';
        for($i=0;$i<$l-$s-$e;$i++){
            $c .= "*";
        }
        return $str1.$c.$str2;
    }

    public function sub_string($string,$length,$end_num=0,$end_str='…',$is_strip=0)
    {
        if($is_strip) $string = strip_tags($string);
        if(mb_strlen($string,"UTF-8")<=$length)
        {
            return $string;
        }
        else
        {
            return mb_substr($string,0,$length,'UTF-8').$end_str;
        }
    }
    /**
     * 联动的示例
     * @AuthorPZ
     * @DateTime 2016-03-17T09:39:56+0800
     * @param    string                   $name         [description]
     * @param    array                    $regions      [description]
     * @param    string                   $default_item [description]
     * @param    string                   $paramStr     [description]
     * @param    string                   $clas_name    [description]
     * @return   [type]                                 [description]
     */
    public function formRegion($name = 'region' ,$regions = array(), $default_item = '请选择',$paramStr='', $clas_name ='')
    {
            $htm = '<select id="'.$name.'1" name="'.$name.'1" onchange="getSubRegion(\'/Region/getSubRegionList/default_item/'.urlencode($default_item."市").'/id/\'+this.value+\'/\',\''.$name.'2\',\''.$name.'3\')" class="refresh_region btn_data '.$clas_name.'"  '.$paramStr.' >';
            $htm.='<option value="0">'.$default_item.'省</option>';
            if(count($regions['provinceList']))
            {
                foreach($regions['provinceList'] as $v)
                {
                    if(isset($regions['default']['province_id']) && $v['sr_id']==$regions['default']['province_id'])
                    {
                        $htm.='<option value="'.$v['sr_id'].'" selected="selected" >'.$v['sr_name'].'</option>';
                    }
                    else
                    {
                        $htm.='<option value="'.$v['sr_id'].'">'.$v['sr_name'].'</option>';
                    }
                }
            }

            $htm .= '</select>';

            $htm .= '<select id="'.$name.'2" name="'.$name.'2" onchange="getSubRegion(\'/Region/getSubRegionList/default_item/'.urlencode($default_item."县").'/id/\'+this.value+\'/\',\''.$name.'3\',\''.$name.'3\')" class="refresh_region btn_data '.$clas_name.'" '.$paramStr.'  >';
            $htm.='<option value="0">'.$default_item.'市</option>';
            if(isset($regions['cityList']) && count($regions['cityList']))
            {
                foreach($regions['cityList'] as $v)
                {
                    if($v['sr_id']==$regions['default']['city_id'])
                    {
                        $htm.='<option value="'.$v['sr_id'].'" selected="selected" >'.$v['sr_name'].'</option>';
                    }
                    else
                    {
                        $htm.='<option value="'.$v['sr_id'].'">'.$v['sr_name'].'</option>';
                    }
                }
            }
            $htm .= '</select>';


            $htm .= '<select id="'.$name.'3" name="'.$name.'3" class="must btn_data '.$clas_name.'" '.$paramStr.' >';
            $htm.='<option value="0">'.$default_item.'县</option>';
            if(isset($regions['districtList']) && count($regions['districtList']))
            {
                foreach($regions['districtList'] as $v)
                {
                    if($v['sr_id']==$regions['default']['district_id'])
                    {
                        $htm.='<option value="'.$v['sr_id'].'" selected="selected" >'.$v['sr_name'].'</option>';
                    }
                    else
                    {
                        $htm.='<option value="'.$v['sr_id'].'">'.$v['sr_name'].'</option>';
                    }
                }
            }

            $htm .= '</select>';
            return $htm.'<script type="text/javascript">
                            function getSubRegion(url,name,def)
                            {
                                $.get(url, function(data){
                                  $("#"+def).html(\'<option value="0">'.$default_item.'县</option>\');
                                  $("#"+name).html(data);
                                });
                            }
                            </script> ';

    }

    public function formText($name, $value = '', $paramStr = '')
    {
        $htm = "<input type='text' name='{$name}' value='{$value}' {$paramStr} />";
        return $htm;
    }

    public function formSelect($name, $options = array(), $value = null, $attrs = '')
    {
        $htm = '<select id="' . $name . '" name="' . $name . '"';
        if (is_string($attrs))
        {
            $htm .= " {$attrs}";
        }
        else if (is_bool($attrs) && $attrs)
        {
            $htm .= ' class="combox"';
        }
        $htm .= '>';
        if (null === $value)
        {
            $value = key($options);
        }
        foreach ($options as $k => $v)
        {
            if ($k == $value)
            {
                $htm .= '<option value="' . $k . '" selected="selected">' . $v . '</option>';
            }
            else
            {
                $htm .= '<option value="' . $k . '">' . $v . '</option>';
            }
        }
        $htm .= '</select>';
        return $htm;
    }

    public function formCheckbox($name, $array = array(), $value, $enclose='', $paramStr='')
    {
        $value = explode(',',$value);
        $htm   = '';
        foreach($array as $k => $v)
        {
            if (in_array($k , $value))
            {
                $htm .= ((empty($enclose))?"":"<$enclose>")."<input id='{$name}{$k}' type='checkbox' checked='checked'  value='{$k}' name='{$name}[]' {$paramStr}><label {$paramStr} for='{$name}{$k}'>{$v}</label>".((empty($enclose))?"":"<$enclose>");
            }
            else
            {
                $htm .= ((empty($enclose))?"":"<$enclose>")."<input id='{$name}{$k}' type='checkbox' value='{$k}' name='{$name}[]' {$paramStr}><label {$paramStr} for='{$name}{$k}'>{$v}</label>".((empty($enclose))?"":"<$enclose>");
            }
        }
        return $htm;
    }
    
    public function formRadio($name, $array = array(), $value, $enclose='', $paramStr='')
    {
        $htm   = '';
        if($value=='')$value='-100';
        foreach($array as $k=>$v)
        {
            if($k==$value)
                $htm .= ((empty($enclose))?"":"<$enclose>")."<input type='radio' value='{$k}' checked='checked' id='{$name}{$k}' name='{$name}' {$paramStr}><label {$paramStr} for='{$name}{$k}'>{$v}</label>".((empty($enclose))?"":"<$enclose>")."&nbsp;&nbsp;";
            else
                $htm .= ((empty($enclose))?"":"<$enclose>")."<input type='radio' value='{$k}'  name='{$name}' id='{$name}{$k}' {$paramStr}><label {$paramStr} for='{$name}{$k}'>{$v}</label>".((empty($enclose))?"":"<$enclose>")."&nbsp;&nbsp;";
        }
        return $htm;
    }

    public function showYesNo($value = false)
    {
        if (empty($value))
            return '--';
        else
            return '是';
    }
    public function displayStyle($value)
    {
        if($value   )
        {
            return 'style="display:;"';
        }else{
            return 'style="display:none;"';
        }

    }
    
    public function showChecked($value = false)
    {
        if (empty($value))
            return '<span style="color:red;font-weight:bold;line-height:21px;">×</span>';
        else
            return '<span style="color:blue;font-weight:bold;line-height:21px;">√</span>';
    }
    public function valToremark($value,$array)
    {
        return $array[$value];
    }
}