<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 27/01/2024
 * Time: 14:18
 */

namespace Bear8421\Bear\Services\Traits;

trait Response
{
	protected $response = array();

	/**
	 * Function getResponse
	 *
	 * User: 713uk13m <dev@nguyenanhung.com>
	 * Copyright: 713uk13m <dev@nguyenanhung.com>
	 * @return array
	 */
	public function getResponse(): array
	{
		return $this->response;
	}
}
