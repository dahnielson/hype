<?php
/**
 * ActionView
 *
 * @author Anders Dahnielson <anders@dahnielson.com>
 * @copyright Anders Dahnielson 2006
 * @package Hype
 */

if (class_exists("Smarty"))
{
	/**
	 * @ignore
	 */
	class ActionViewBase extends Smarty
	{
		function ActionViewBase()
		{
			$this->Smarty();
		}
	}
}
else if (class_exists("Template_Lite"))
{
	/**
	 * @ignore
	 */
	class ActionViewBase extends Smarty
	{
		function ActionViewBase()
		{
			$this->Smarty();
		}
	}
}
else
{
	/**
	 * @ignore
	 */
	class ActionViewBase
	{
		function ActionViewBase()
		{
			die("No template class present!");
		}
	}
}

/**
 * ActionView
 *
 * @package Hype
 */
class ActionView extends ActionViewBase
{
	function ActionView()
	{
		$this->ActionViewBase();
    
		$this->left_delimiter = "<?tpl";
		$this->right_delimiter = "?>";
    
		$this->config_dir = CONFIG_ROOT.'/';
		$this->compile_dir = TMP_ROOT.'/templates/';
		$this->cache_dir = TMP_ROOT.'/cache/';
		$this->template_dir = HYPE_ROOT.'/public/';
	}
}
?>