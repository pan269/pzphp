<?php
/**
* 系统类
*/
class System
{
	
	function __construct()
	{
		# code...
	}

	/**
	 * 加载插件
	 * 插件只能加载一次
	 * @Author pz
	 * @Date   2016-05-05
	 * @param  [type]     $plugin_name 仅仅加载类的插件,插件文件名称为类名
	 * @param  [type]     $dir        必须为前面带/ 后面不带的 即 /a 这样的格式
	 */
	public static function LoadPlugin($plugin_name,$dir='')
	{
        require PZ_DIR.DS.'plugin'.$dir.DS.$plugin_name.'.php';

	}

}