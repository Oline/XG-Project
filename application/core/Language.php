<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 3.0.0
 */

if ( ! defined ( 'INSIDE' ) ) { die ( header ( 'location:../../' ) ) ; }

class Language
{
	private $lang;
	private $langExtension = 'php';

	/**
	 * __construct()
	 */
	public function __construct()
	{
		$languagesLoaded	= $this->getFileName();

		foreach ( $languagesLoaded as $load )
		{
			$route	= XGP_ROOT . LANG_PATH . DEFAULT_LANG . '/' . $load . '.' . $this->langExtension;

			if ( file_exists ( $route ) ) // WE GOT SOMETHING
			{
				// GET THE LANGUAGE PACK
				include ( $route );
			}
		}

		if ( ! empty ( $lang ) ) // WE GOT SOMETHING
		{
			// SET DATA
			$this->lang	= $lang;
		}
		else
		{
			// THROW EXCEPTION
            // This seems to be a bad way to stop stuff in contructors
			die ( 'Language file not found or empty: <strong>' . $load . '</strong><br />Location: <strong>' . $route . '</strong>' );
		}
	}

	/**
	 * method lang
	 * param
	 * return the language data
	 */
	public function lang()
	{
		return $this->lang;
	}

	/**
	 * method getFileName
	 * param
	 * return language pack file
	 */
	private function getFileName()
	{
		if ( defined ( 'IN_ADMIN' ) )
		{
			$required[] = 'ADMIN';
		}

		if ( defined ( 'IN_CHANGELOG' ) )
		{
			$required[] = 'CHANGELOG';
		}

		if ( defined ( 'IN_GAME' ) )
		{
			$required[] = 'INGAME';
		}

		if ( defined ( 'IN_INSTALL' ) )
		{
			$required[] = 'INSTALL';
		}

		if ( defined ( 'IN_LOGIN' ) )
		{
			$required[] = 'HOME';
		}

		return $required;
	}
}

/* end of Language.php */
