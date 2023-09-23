<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 31/07/2023
 * Time: 13:18
 */

namespace Bear8421\Bear\Services\API;

use Bear8421\Bear\Services\Environment;
use Bear8421\Bear\Services\Traits\Helper;
use Bear8421\Bear\Services\Traits\Version;
use Bear8421\Bear\Services\Request\Request;

/**
 * Class HungNgPublicServices
 *
 * @package   Bear8421\Bear\Services\API
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class HungNgPublicServices implements Environment
{
    use Version, Helper;

    const ENDPOINT = 'https://api.nguyenanhung.com';

    /**
     * Function getMe
     *
     * @return mixed|object|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 31/07/2023 14:39
     */
    public function getMe()
    {
        $request = new Request();
        $api = self::ENDPOINT . '/me';
        $json = $request->sendRequest($api);
        if ($this->isJson($json)) {
            return json_decode($json, false);
        }
        return null;
    }

    /**
     * Function getInfoOfMe
     *
     * @return mixed|object|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 31/07/2023 14:56
     */
    public function getInfoOfMe()
    {
        $me = $this->getMe();
        return $me->info ?? null;
    }
}
