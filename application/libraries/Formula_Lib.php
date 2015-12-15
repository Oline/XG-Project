<?php

/**
 * @package		XG Project
 * @copyright	Copyright (c) 2008 - 2015
 * @license		http://opensource.org/licenses/gpl-3.0.html	GPL-3.0
 * @since		Version 3.0.0
 */

if ( ! defined ( 'INSIDE' ) ) { die ( header ( 'location:../../' ) ) ; }

class Formula_Lib extends XGPCore
{
	/**
	 * __construct()
	 */
	public function __construct ()
	{
		parent::__construct();
	}

	/**
	 * method phalanx_range
	 * param $phalanx_level
	 * return the plalanx range
	 */
	public function phalanx_range ( $phalanx_level )
	{
		$range = 0;

		if ( $phalanx_level > 1 )
		{
			$range = pow ( $phalanx_level , 2 ) - 1;
		}
		elseif ( $phalanx_level == 1 )
		{
			$range = 1;
		}

		return $range;
	}

	/**
	 * method missile_range
	 * param $impulse_drive_level
	 * return the missile range
	 */
	public function missile_range ( $impulse_drive_level )
	{
		if ( $impulse_drive_level > 0 )
		{
			return ( $impulse_drive_level * 5 ) - 1;
		}

		return 0;
	}
}
/* end of Formula_Lib.php */
