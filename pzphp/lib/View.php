<?php
/**
 * 视图引擎
 * 视图引擎本来想自己实现的,不过过于繁琐,决定采用第三方的
 * 目前把第三方模板适配进来
 * 目前已适配blitz
 * 
 */

class view {
    /**
     * template path
     * @var string
     */
    protected $_T;
    protected $_C;
    protected $_A;
    protected $_E;
    protected $_P;
    protected $_F;

    /**
     * Constructor
     *
     * @param   string      $tmplPath
     * @param   array       $extraParams
     * @return  void
     */
    public function __construct()
    {
        $this->_T = new BlitzView();
        $this->_C = strtolower( Register::get('router')['c']); //获取路径controller
        $this->_A = strtolower(Register::get('router')['a']); //获取路径action
        $this->_E = strtolower(Register::get('config')['view']['ext']); //获取文件ext
        $this->_P = APP_DIR.DS."view".DS.$this->_C.DS;
        $this->_F = $this->_A.$this->_E;
    }

    public function setPath($path)
    {
        if($path)
        {
            if(substr($path, 0, -1) == DS)
            {
                $this->_P = $path;
            }
            else
            {
                $this->_P = DS.$path;
            }
        }
        # code...
    }

    public function setFile($file)
    {
        if($file)
        {
            if (substr( $file, 0, 1 ) == '.') 
            {
                $this->_F = $file;
            }
            else
            {
                $this->_F = '.'.$file;
            }
        }
        # code...
    }


    public function setView($view)
    {
        if($view)
        {
            $viewname = $view."View";
            $this->_T = new $viewname;
        }
        # code...
    }

    public function setParams($Params)
    {
        if (!empty($Params))
        {
            $this->assign($Params);
        }
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
        $this->_T->assign($spec, $value = null);
    }

    /**
     * Processes a template and display the output.
     *
     * @param   string          $view_file
     * @param   array           $tpl_vars  (Optional)
     * @return  string
     */
    public function display($tpl_vars = null)
    {
        $this->_T->display($this->_P,$this->_F, $tpl_vars = null);
    }

}