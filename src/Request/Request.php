<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/16/2021
 * Time: 16:28
 */

namespace Bear8421\Bear\Services\Request;

use Bear8421\Bear\Services\Environment;
use Exception;
use Curl\Curl;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Bear8421\Bear\Services\Traits\Version;

/**
 * Class Request
 *
 * @package   Bear8421\Bear\Services\Request
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Request implements Environment
{
    use Version;

    /** @var array Monolog configure */
    protected $mono = [
        'dateFormat'         => "Y-m-d H:i:s u",
        'outputFormat'       => "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
        'monoBubble'         => true,
        'monoFilePermission' => 0777
    ];

    /** @var bool $DEBUG status */
    protected $DEBUG;

    /** @var string Logger Path */
    protected $loggerPath;

    /** @var string Logger File */
    protected $loggerFile;

    /** @var int Request Timeout */
    protected $timeout = 60;

    /** @var array|null Header List */
    protected $header;

    /** @var string $authUsername */
    protected $authUsername;

    /** @var string $authPassword */
    protected $authPassword;

    /** @var string|null $authBearerToken */
    protected $authBearerToken;

    /** @var bool $basicAuthentication */
    protected $basicAuthentication = false;

    /** @var bool $digestAuthentication */
    protected $digestAuthentication = false;

    /** @var bool $isJson */
    protected $isJson = false;

    /** @var bool $isXml */
    protected $isXml = false;

    /**
     * Requests constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
        $this->loggerFile = 'Log-' . date('Y-m-d') . '.log';
    }

    /**
     * Function setDebugStatus
     *
     * @param bool $status
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 54:50
     */
    public function setDebugStatus(bool $status = true): Request
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
     * @time     : 09/16/2021 56:19
     */
    public function setLoggerPath(string $loggerPath = ''): Request
    {
        $this->loggerPath = $loggerPath;

        return $this;
    }

    /**
     * Function setTimeout
     *
     * @param $timeout
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 07/27/2021 31:11z
     */
    public function setTimeout($timeout): Request
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Function setHeader
     *
     * @param array $header
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 07/27/2021 31:22
     */
    public function setHeader(array $header = []): Request
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Function setIsJson
     *
     * @param bool $isJson
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 58:42
     */
    public function setIsJson(bool $isJson = true): Request
    {
        $this->isJson = $isJson;

        return $this;
    }

    /**
     * Function setIsXml
     *
     * @param bool $isXml
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 02:27
     */
    public function setIsXml(bool $isXml = true): Request
    {
        $this->isXml = $isXml;

        return $this;
    }

    /**
     * Function setUserAuthentication
     *
     * @param string $username
     * @param string $password
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 48:32
     */
    public function setUserAuthentication(string $username = '', string $password = ''): Request
    {
        $this->authUsername = $username;
        $this->authPassword = $password;

        return $this;
    }

    /**
     * Function setAuthBearerToken
     *
     * @param string $authBearerToken
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 24:56
     */
    public function setAuthBearerToken(string $authBearerToken): Request
    {
        $this->authBearerToken = $authBearerToken;

        return $this;
    }

    /**
     * Function isBasicAuthentication
     *
     * @param bool $status
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 51:57
     */
    public function isBasicAuthentication(bool $status = false): Request
    {
        $this->basicAuthentication = $status;

        return $this;
    }

    /**
     * Function isDigestAuthentication
     *
     * @param bool $status
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 52:01
     */
    public function isDigestAuthentication(bool $status = false): Request
    {
        $this->digestAuthentication = $status;

        return $this;
    }

    /**
     * Function sendRequest
     *
     * @param string $url
     * @param array  $data
     * @param string $method
     *
     * @return string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/13/2021 00:46
     */
    public function sendRequest(string $url = '', array $data = [], string $method = 'GET')
    {
        try {
            $getMethod = strtoupper($method);
            // create a log channel
            $formatter = new LineFormatter($this->mono['outputFormat'], $this->mono['dateFormat']);
            $stream = new StreamHandler($this->loggerPath . 'sendRequest/' . $this->loggerFile, Logger::INFO, $this->mono['monoBubble'], $this->mono['monoFilePermission']);
            $stream->setFormatter($formatter);
            $logger = new Logger('Curl');
            $logger->pushHandler($stream);
            if ($this->DEBUG === true) {
                $logger->info('||====================== Logger Requests ======================||');
                $logger->info($getMethod . ' Request to ' . $url, $data);
            }
            // Curl
            $curl = new Curl();
            $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
            $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
            $curl->setOpt(CURLOPT_ENCODING, "utf-8");
            $curl->setOpt(CURLOPT_MAXREDIRS, 10);
            $curl->setOpt(CURLOPT_TIMEOUT, $this->timeout);
            if (($this->header)) {
                $curl->setHeaders($this->header);
            }
            if ($this->basicAuthentication) {
                $curl->setBasicAuthentication($this->authUsername, $this->authPassword);
            }
            if ($this->digestAuthentication) {
                $curl->setDigestAuthentication($this->authUsername, $this->authPassword);
            }
            if ($this->isJson) {
                $curl->setHeader("Content-Type", "application/json");
            }
            if ($this->isXml) {
                $curl->setHeader("Content-Type", "text/xml");
            }
            if (is_string($this->authBearerToken)) {
                $curl->setHeader("Authorization", 'Bearer ' . $this->authBearerToken);
            }
            // Request
            if ('POST' === $getMethod) {
                $curl->post($url, $data);
            } elseif ('PUT' === $getMethod) {
                $curl->put($url, $data);
            } elseif ('PATCH' === $getMethod) {
                $curl->patch($url, $data);
            } elseif ('HEAD' === $getMethod) {
                $curl->head($url, $data);
            } elseif ('OPTIONS' === $getMethod) {
                $curl->options($url, $data);
            } elseif ('SEARCH' === $getMethod) {
                $curl->search($url, $data);
            } elseif ('JSON' === $getMethod) {
                $curl->setHeader("Content-Type", "application/json");
                $curl->post($url, $data);
            } else {
                $curl->get($url, $data);
            }
            // Response
            if ($curl->error) {
                $response = "cURL Error: " . $curl->errorMessage;
            } elseif (isset($curl->rawResponse)) {
                $response = $curl->rawResponse;
            } else {
                $response = $curl->response;
            }
            // Close Request
            $curl->close();
            // Log Response
            if ($this->DEBUG === true) {
                if (is_array($response) || is_object($response)) {
                    $logger->debug('Response from Request: ' . json_encode($response));
                } else {
                    $logger->debug('Response from Request: ' . $response);
                }
            }

            // Return Response
            return $response;
        } catch (Exception $e) {
            if (function_exists('log_message')) {
                log_message('error', $e->getMessage());
                log_message('error', $e->getTraceAsString());
            }

            return null;
        }
    }

    /**
     * Function xmlRequest
     *
     * @param string $url
     * @param string $data
     * @param int    $timeout
     *
     * @return bool|string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 07/27/2021 32:35
     */
    public function xmlRequest(string $url = '', string $data = '', int $timeout = 60)
    {
        if (empty($url) || empty($data)) {
            return null;
        }
        try {
            // create a log channel
            $formatter = new LineFormatter($this->mono['outputFormat'], $this->mono['dateFormat']);
            $stream = new StreamHandler($this->loggerPath . 'xmlRequest/' . $this->loggerFile, Logger::INFO, $this->mono['monoBubble'], $this->mono['monoFilePermission']);
            $stream->setFormatter($formatter);
            $logger = new Logger('request');
            $logger->pushHandler($stream);
            if ($this->DEBUG === true) {
                $logger->info('||=========== Logger xmlRequest ===========||');
                $logger->info('Request URL: ' . $url . ' with Data: ' . $data);
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            $head[] = "Content-type: text/xml;charset=utf-8";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $page = curl_exec($ch);
            curl_close($ch);
            if ($this->DEBUG === true) {
                $logger->info('Response from Request: ' . $page);
            }

            return $page;
        } catch (Exception $e) {
            if (function_exists('log_message')) {
                log_message('error', $e->getMessage());
                log_message('error', $e->getTraceAsString());
            }

            return null;
        }
    }

    /**
     * Function xmlGetValue
     *
     * @param $xml
     * @param $openTag
     * @param $closeTag
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/03/2021 30:05
     */
    public function xmlGetValue($xml, $openTag, $closeTag): string
    {
        $f = strpos($xml, $openTag) + strlen($openTag);
        $l = strpos($xml, $closeTag);

        return ($f <= $l) ? substr($xml, $f, $l - $f) : "";
    }
}
