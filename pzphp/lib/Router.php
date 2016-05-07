<?php
/**
 * 路由
 */
class Router
{
    /**
     * c载入
     * @Author pz
     * @Date   2016-05-05
     * @return [type]     [description]
     */
	public static function dispatch()
	{
        $url_path = Router::_urlDecompose();
        $class_name = $url_path['c'] .'Controller' ; 
        $o = new $class_name;
        $a = $url_path['a'] .'Action' ; 
        $o->beforeAction();
        call_user_func( array( $o , $a ) );
        $o->afterAction();
	}

    /**
     * 解码url参数
     * @Author pz
     * @Date   2016-05-05
     * @return 
     */
    private static function _urlDecompose()
    {
        $re = array();
        $base = $_SERVER['REQUEST_URI'];
        $re['c'] = ucfirst(Register::get('config')['defaut']['controller']);
        $re['a'] = ucfirst(Register::get('config')['defaut']['action']);

        //支持/和?混合写的形式,不过?后面的参数必须遵循_GET的规范
        $base_para = explode('?', $base);
        // if($base_para[0] == '/')
        // {
        //     return $re;
        // }

        $re_arr = explode('/', $base_para[0]);
        
        unset($re_arr[0]);
        if($re_arr[1]){
            $re['c'] = ucfirst($re_arr[1]);
            unset($re_arr[1]);
        }
        if($re_arr[2]){
            $re['a'] = ($re_arr[2]);
            unset($re_arr[2]);
        }
        
        $i = 1;
        $key = '';
        $para = array();
        foreach ($re_arr as $k=>$v) {
            if($i%2)
            {
                $key = $v;
            }
            else
            {
                $para[$key] = $v;
            }
            $i++;
        }
        $re['p'] = $para;
        Register::set('router',$re);
        return $re;
    }
}