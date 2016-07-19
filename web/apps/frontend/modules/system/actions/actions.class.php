<?php
/**
 * system actions.
 *
 * @package		vanilka
 * @subpackage system
 * @author		 Your name here
 * @version		SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class systemActions extends sfActions
{
	/**
	 * Smazani cache
	 * @param sfWebRequest $request
	 */
	public function executeClearCache (sfWebRequest $request)
	{
		$path = sfConfig::get('sf_cache_dir');
		exec('rm -rf ' . $path . '/*');
		echo $path.'<br />';
		die('ok');
	}
}
