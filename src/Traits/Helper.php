<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 31/07/2023
 * Time: 13:15
 */

namespace Bear8421\Bear\Services\Traits;

/**
 * Trait Helper
 *
 * @package   Bear8421\Bear\Services\Traits
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
trait Helper
{
	/**
	 * Returns true if the string is JSON, false otherwise. Unlike json_decode
	 * in PHP 5.x, this method is consistent with PHP 7 and other JSON parsers,
	 * in that an empty string is not considered valid JSON.
	 *
	 * @return bool TRUE if $str is JSON
	 */
	protected function isJson($str): bool
	{
		if ( ! $this->strLength($str)) {
			return false;
		}

		json_decode($str);

		return (json_last_error() === JSON_ERROR_NONE);
	}

	/**
	 * Returns the length of the string. An alias for PHP's mb_strlen() function.
	 *
	 * @return int The number of characters in $str given the encoding
	 */
	protected function strLength($str): int
	{
		return mb_strlen($str, mb_internal_encoding());
	}
}
