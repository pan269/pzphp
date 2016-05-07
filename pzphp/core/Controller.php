<?php
/**
 * 视图引擎
 */

abstract class Controller {
    // protected 
    /**
    * 获取参数
    * @AuthorPZ
    * @DateTime 2016-03-15T08:39:22+0800
    * @return   unknow   $para
    * 优先级 post>get>直接加在后面
    * 
    */
    public final function getParam($key,$val='')
  	{
		$router_para = Register::get('router')['p'];
		if($_POST[$key])
		{
			$para = $_POST[$key];
		}
		else if($_GET[$key])
		{
			$para = $_GET[$key];
		}
		else if ($router_para[$key]) 
		{
			$para = $router_para[$key];
		}
		else
		{
			$para = $val;
		}
		return $para;
  	}
	public final function display($arr)
	{
		$View = new View();
        if(!empty($arr))
        {
            $View->assign($arr);
        }
		$View->display();

	}
	public final function redirect($url='')
	{

	}  



    public final function beforeAction()
    {
       // echo 'beforeAction'; 
        # code...
    }

    public final function afterAction()
    {
        
        # code...
    }
}