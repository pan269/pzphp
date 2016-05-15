<?php
/**
 * blitz 引擎
 */
class LiquidView extends LiquidTemplate 
{
    public function __construct()
    {
        // parent::__construct();
    }

   

    /**
     * Processes a template and display the output.
     *
     * @param   array           $tpl_vars  (Optional)
     * @return  null || string
     */
    public function display($tpl_vars)
    {

        $this->render($tpl_vars);
    }
    
}