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

    /**
     * Constructor
     *
     * @param   string      $tmplPath
     * @param   array       $extraParams
     * @return  void
     */
    public function __construct()
    {
        // $this->_T = new BlitzView();
        
        $this->_T = new LiquidView(); 
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
        // $this->_T->display($tpl_vars = null);
    }

}