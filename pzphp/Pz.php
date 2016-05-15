<?php
/**
* 
*/

class Pz 
{
    /**
     * 应用初始化
     * @Author pz
     * @Date   2016-05-05
     * @param  string     $ini ini文件地址
     * @return 
     */
    public static function start($ini='')
    {
        if(!$ini){
            $ini = APP_DIR.DS."config".DS.'config.ini';
        }
        
        System::LoadPlugin('Liquid','/view/liquid');
        //注册自动加载类
        spl_autoload_register('Pz::pzAutoload');
         // 设定错误和异常处理
        register_shutdown_function('Pz::pzFatalError');
        set_error_handler('Pz::pzAppError');
        set_exception_handler('Pz::pzAppException');
        //加载配置文件
        $config = Config::parse_ini_file_multi($ini);
        //挂在全局树上面
        Register::set('config',$config);
        //注册路由
        Router::dispatch();
    }

    /**
     * 自动载入
     * @Author pz
     * @Date   2016-05-05
     * @param   $class 类名
     * @return
     */
    public static function pzAutoload($class)
    {
        if($class == 'Controller' || $class == 'Model' || $class == 'View')
        {
            require PZ_DIR.DS.'core'.DS.$class.'.php';
        }
        
        else if(strpos($class, 'Model'))
        {
            require APP_DIR.DS.'model'.DS.$class.'.php';
        }
        else if (strpos($class, 'Controller'))
        {
            require APP_DIR.DS.'controller'.DS.$class.'.php';
        }
        else if (strpos($class, 'Plugin'))
        {
            require PZ_DIR.DS.'plugin'.DS.$class.'.php';
        }
        else if (strpos($class, 'View'))
        {
            require PZ_DIR.DS.'view'.DS.$class.'.php';
        }
        else
        {
            require PZ_DIR.DS.'lib'.DS.$class.'.php';
        }
    }

     // 致命错误捕获
    public static function pzFatalError()
    {
        if ($e = error_get_last()) {
            switch ($e['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    break;
            }
        }
    }

    /**
     * 自定义错误处理
     * @access public
     * @param int $errno 错误类型
     * @param string $errstr 错误信息
     * @param string $errfile 错误文件
     * @param int $errline 错误行数
     * @return void
     */
    public static function pzAppError($errno, $errstr, $errfile, $errline)
    {
        switch ($errno) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                break;
            default:
                break;
        }
    }

     /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
    public static function pzAppException($e)
    {
        $error            = array();
        $error['message'] = $e->getMessage();
        $trace            = $e->getTrace();
    }
}
