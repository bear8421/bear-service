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

    private $toArrayResponse = false;

    public function toArray(): self
    {
        $this->toArrayResponse = true;
        return $this;
    }

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
            if ($this->toArrayResponse === true) {
                return json_decode($json, true);
            }
            return json_decode($json, false);
        }
        return null;
    }

    /**
     * Function getCurrentIP
     *
     * User: 713uk13m <dev@nguyenanhung.com>
     * Copyright: 713uk13m <dev@nguyenanhung.com>
     * @return mixed|null
     */
    public function getCurrentIP()
    {
        $request = new Request();
        $api = self::ENDPOINT . '/ip';
        $json = $request->sendRequest($api);
        if ($this->isJson($json)) {
            if ($this->toArrayResponse === true) {
                return json_decode($json, true);
            }
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
        if ($this->toArrayResponse === true) {
            return $me['info'] ?? null;
        }
        return $me->info ?? null;
    }

    /**
     * Function getProfileOfMe
     *
     * @return mixed|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 31/10/2023 16:35
     */
    public function getProfileOfMe()
    {
        $request = new Request();
        $api = self::ENDPOINT . '/me/profile';
        $json = $request->sendRequest($api);
        if ($this->isJson($json)) {
            if ($this->toArrayResponse === true) {
                return json_decode($json, true);
            }
            return json_decode($json, false);
        }
        return null;
    }
}
