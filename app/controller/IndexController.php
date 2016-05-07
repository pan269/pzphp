<?php
/**
* 
*/
class IndexController extends Controller
{
    
    function __construct()
    {
        # code...
    }
    public function indexAction()
    {
        $para = array('hello'=>"Hello World!!");
        $this->display($para);
        # code...
    }
    public function xxxAction()
    {
        echo "xxx!!!";
        # code...
    }
}
