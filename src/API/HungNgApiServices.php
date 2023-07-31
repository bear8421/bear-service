<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/16/2021
 * Time: 17:04
 */

namespace Bear8421\Bear\Services\API;

use Bear8421\Bear\Services\Environment;
use Bear8421\Bear\Services\Traits\Helper;
use Bear8421\Bear\Services\Traits\Version;
use Bear8421\Bear\Services\Request\Request;

/**
 * Class HungNgApiServices
 *
 * @package   Bear8421\Bear\Services\API
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class HungNgApiServices implements Environment
{
    use Version, Helper;

    const ENDPOINT = 'https://api.nguyenanhung.com/api/v1';

    /** @var string $clientId */
    protected $clientId;

    /** @var string $clientPrefix */
    protected $clientPrefix;

    /** @var string $secretToken */
    protected $secretToken;

    /** @var string $bearerToken */
    protected $bearerToken;

    /** @var bool $DEBUG status */
    protected $DEBUG = false;

    /** @var string|null Logger Path */
    protected $loggerPath = '';

    /**
     * HungNgApiServices constructor.
     *
     * @param $clientId
     * @param $clientPrefix
     * @param $secretToken
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct($clientId, $clientPrefix, $secretToken)
    {
        $this->clientId = $clientId;
        $this->clientPrefix = $clientPrefix;
        $this->secretToken = $secretToken;
    }

    /**
     * Function generateSignature
     *
     * @param string $serverId
     * @param string $username
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/03/2021 41:06
     */
    protected function generateSignature(string $serverId, string $username): string
    {
        $validSignStr = $this->clientId . $this->clientPrefix . $this->secretToken . $serverId . $username;

        return sha1($validSignStr);
    }

    /**
     * Function setDebugStatus
     *
     * @param bool $status
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 09:53
     */
    public function setDebugStatus(bool $status = true): HungNgApiServices
    {
        $this->DEBUG = $status;

        return $this;
    }

    /**
     * Function setLoggerPath
     *
     * @param string $loggerPath
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 09:50
     */
    public function setLoggerPath(string $loggerPath = ''): HungNgApiServices
    {
        $this->loggerPath = $loggerPath;

        return $this;
    }

    /**
     * Function setClientId
     *
     * @param string $clientId
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 14:12
     */
    public function setClientId(string $clientId): HungNgApiServices
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Function setClientPrefix
     *
     * @param string $clientPrefix
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 14:32
     */
    public function setClientPrefix(string $clientPrefix): HungNgApiServices
    {
        $this->clientPrefix = $clientPrefix;

        return $this;
    }

    /**
     * Function setSecretToken
     *
     * @param string $secretToken
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 14:48
     */
    public function setSecretToken(string $secretToken): HungNgApiServices
    {
        $this->secretToken = $secretToken;

        return $this;
    }

    /**
     * Function setBearerToken
     *
     * @param string $bearerToken
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 13:44
     */
    public function setBearerToken(string $bearerToken): HungNgApiServices
    {
        $this->bearerToken = $bearerToken;

        return $this;
    }

    /**
     * Function createOrUpdateHtpasswd
     *
     * @param string $username
     * @param string $password
     * @param string $serverId
     *
     * @return string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/04/2021 34:49
     */
    public function createOrUpdateHtpasswd(string $username = '', string $password = '', string $serverId = '')
    {
        $request = new Request();
        $request->setDebugStatus($this->DEBUG)->setLoggerPath($this->loggerPath)->setAuthBearerToken($this->bearerToken);
        $uri = '/htpasswd/createOrUpdate';
        $params = [
            'clientId'  => $this->clientId,
            'signature' => $this->generateSignature($serverId, $username),
            'username'  => $username,
            'password'  => $password,
            'server_id' => $serverId
        ];

        return $request->sendRequest(self::ENDPOINT . $uri, $params, 'POST');
    }

    /**
     * Function getListUser
     *
     * @param string $username
     * @param string $serverId
     *
     * @return string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/04/2021 34:05
     */
    public function getListUser(string $username = '', string $serverId = '')
    {
        $request = new Request();
        $request->setDebugStatus($this->DEBUG)->setLoggerPath($this->loggerPath)->setAuthBearerToken($this->bearerToken);
        $uri = '/htpasswd/getListUser';
        $params = [
            'clientId'  => $this->clientId,
            'signature' => $this->generateSignature($serverId, $username),
            'username'  => $username,
            'server_id' => $serverId
        ];

        return $request->sendRequest(self::ENDPOINT . $uri, $params);
    }
}
