<?php

/**
 * mysqli 类
 */

class Mysqli extends DB{
    private $db_host;       //连接主机
    private $db_user;       //mysql用户名
    private $db_pwd;        //密码
    private $db_name;       //选择的库
    private $db_charset;    //编码

    private $dbh;           //连接句柄

    private $con_mode       //连接模式  1 临时连接 2 永久连接

    private $con_mode       //连接模式  1 临时连接 2 永久连接

    private $error_path;     // 错误日志

    
    public function __construct()
    {
        $this->db_host      = $db_host;
        $this->db_user      = $db_user;
        $this->db_pwd       = $db_pwd;
        $this->db           = $db_name;
        $this->db_charset   = utf8;
        $this->dbh          = false;
        $this->con_mode     = 1;
        $this->error_path   = 'sql_error.log';
    }

    /**
     * destroy class
     */
    function __destruct()
    {
        $this->close();
    }

    public function setHost($host)
    {
        if(filter_var($host,FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)){
            $this->db_host = $host;  
        }
    }

    public function setUser($user)
    {
        if(filter_var($host,FILTER_SANITIZE_STRIPPED)){
            $this->db_user = $user;  
        }
    }

    public function setPass($pass)
    {
        if(filter_var($pass,FILTER_SANITIZE_STRIPPED)){
            $this->db_pass = $pass;  
        }
    }

    public function setCharset($charset)
    {
        if(filter_var($charset,FILTER_SANITIZE_STRIPPED)){
            $this->db_charset = $charset;  
        }
    }

    public function setErrorpath($path)
    {
        if(is_file($path)){
            $this->error_path = $path;
        }elseif(is_dir($path)){
            $this->error_path = rtrim($path,"/")."/sql_error.log";
        }
    }
    public function setMode($mode)
    {
        if($mode == 1 && $mode == 2){
            $this->con_mode = $mode;
        }else{
            $this->error('设置错误的模式mode:'.$mode);
        }
    }

    /**
     * 建立数据库连接
     * @AuthorPZ
     * @DateTime 2016-04-06T14:07:58+0800
     * @return  
     */
    private function connect()
    {
        if($this->con_mode == 1)
        {
            if(!is_resource($this->dbh))
            {
                $this->dbh=mysqli_connect($this->db_host,$this->db_user,$this->db_pwd,$this->db_name);
            }
        }else{
            $this->dbh=mysqli_connect($this->db_host,$this->db_user,$this->db_pwd,$this->db_name);
        }
    }

    /**
     * 关闭数据库连接
     * @AuthorPZ
     * @DateTime 2016-04-06T14:07:58+0800
     * @return  
     */
    private function close()
    {
        if (is_resource($this->dbh)) {
            mysqli_close($this->dbh);
        }
    }

    public function escape($val) {
        return mysqli_real_escape_string($this->dbh,stripslashes(trim($val)));
    }

    /**
     * filter value
     */
    public function filter_value($values) {

        if (is_array($values)) {
            $arr = array();
            foreach ($values as $k => $v) {
                if ($v == '=NOW()') {
                    $arr[] = $k . $v;
                } else {
                    $arr[] = $k . "='" . $this->escape($v) . "'";
                }
            }
            return implode(',', $arr);
        } else {
            return false;
        }
    }


    /**
     * *
     * @AuthorPZ
     * @DateTime 2016-04-08T11:29:56+0800
     * @param    $sql   sql语句
     */
    public function select($sql)
    {
        # code...
    }

    /**
     * *
     * @AuthorPZ
     * @DateTime 2016-04-08T11:29:56+0800
     * @param    $sql   sql语句
     */
    public function select_row($sql)
    {
        # code...
    }

    /**
     * *
     * @AuthorPZ
     * @DateTime 2016-04-08T11:29:56+0800
     * @param    $table     数据表
     * @param    $key       字段
     */
    public function select_one($table,$key)
    {
        # code...
    }

    /**
     * *
     * @AuthorPZ
     * @DateTime 2016-04-08T11:29:56+0800
     * @param    $table     数据表
     * @param    $key       字段
     */
    public function update($table,$key)
    {
        # code...
    }

}