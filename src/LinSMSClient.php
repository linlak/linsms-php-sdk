<?php

namespace LinSms;

use LinSms\Bootstrap\Init;

/**
 * 
 */
class LinSMSClient
{

	private function __construct()
	{ }
	/**
	 * @param string [$client_id]
	 * @param string [$secret]
	 * 
	 * @return \LinSms\Bootstrap\Init
	 */
	public static function init($client_id, $secret)
	{
		return new Init($client_id, $secret);
	}
}
