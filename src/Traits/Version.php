<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/16/2021
 * Time: 16:29
 */

namespace Bear8421\Bear\Services\Traits;

/**
 * Trait Version
 *
 * @package   Bear8421\Bear\Services\Traits
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
trait Version
{
    public function getVersion(): string
    {
        return self::VERSION;
    }
}
