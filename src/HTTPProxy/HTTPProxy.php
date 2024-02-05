<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 06/02/2024
 * Time: 05:21
 */

namespace Bear8421\Bear\Services\HTTPProxy;

use Bear8421\Bear\Services\Environment;
use Bear8421\Bear\Services\Traits\Helper;
use Bear8421\Bear\Services\Traits\Response;
use Bear8421\Bear\Services\Traits\Version;
use nguyenanhung\MyRequests\MyRequests;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HTTPProxy implements Environment
{
	const EXIT_SUCCESS = 0;
	const EXIT_ERROR = 1;
	const EXIT_USER_INPUT = 7;

	use Version, Helper, Response;

	protected $authConfig;

	public function setAuthConfig($authConfig): HTTPProxy
	{
		$this->authConfig = $authConfig;
		return $this;
	}

	public function simpleProxy($options = array()): HTTPProxy
	{
		$authUsername = $this->authConfig['username'] ?? null;
		$authPassword = $this->authConfig['password'] ?? null;

		$username = $options['username'] ?? null;
		$signature = $options['signature'] ?? null;
		$url = $options['url'] ?? null;
		$params = $options['params'] ?? null;
		$method = $options['method'] ?? null;
		$with = $options['with'] ?? null;

		$validStr = trim($authUsername) . '|' . trim($url) . '|' . trim($authPassword);
		$validSign = md5($validStr);
		$parseUrl = parse_url($url);

		if (empty($authUsername) || empty($authPassword) || empty($username) || empty($signature) || empty($url)) {
			$response = [
				'code' => self::EXIT_ERROR,
				'message' => 'Missing Required Params'
			];
		} elseif ($signature !== $validSign) {
			$response = [
				'code' => self::EXIT_USER_INPUT,
				'message' => 'Access Signature invalid '
			];
			if ($username === $authUsername) {
				$response['validSign'] = $validSign;
			}
		} elseif (!isset($parseUrl['host'])) {
			$response = [
				'code' => self::EXIT_USER_INPUT,
				'message' => 'Input URL Not Valid'
			];
		} else {
			$request = new MyRequests();
			if (empty($params)) {
				$params = array();
			}
			if (empty($method)) {
				$method = 'GET';
			}
			$res = $request->setRequestNoVerify()->guzzlePhpRequest($url, $params, $method);
			$response = array(
				'status' => self::EXIT_SUCCESS,
				'message' => 'OK',
				'data' => $res
			);
		}
		$this->response = $response;
		return $this;
	}

	public function requestProxy($options = array()): HTTPProxy
	{
		$authUsername = $this->authConfig['username'] ?? null;
		$authPassword = $this->authConfig['password'] ?? null;

		$username = $options['username'] ?? null;
		$signature = $options['signature'] ?? null;
		$url = $options['url'] ?? null;
		$params = $options['params'] ?? null;
		$method = $options['method'] ?? null;
		$with = $options['with'] ?? null;
		$timeout = $options['timeout'] ?? null;
		$disabled_verify = $options['disabled_verify'] ?? null;
		$allow_redirects = $options['allow_redirects'] ?? null;
		$http_auth = $options['http_auth'] ?? null;
		$http_body = $options['http_body'] ?? null;
		$http_headers = $options['http_headers'] ?? null;
		$http_proxy = $options['http_proxy'] ?? null;
		$http_version = $options['http_version'] ?? null;
		$http_query = $options['http_query'] ?? null;
		$http_json = $options['http_json'] ?? null;
		$form_params = $options['form_params'] ?? null;
		$form_multipart = $options['form_multipart'] ?? null;

		$validStr = trim($authUsername) . '|' . trim($url) . '|' . trim($authPassword);
		$validSign = md5($validStr);
		$parseUrl = parse_url($url);
		if (empty($username) || empty($signature) || empty($url)) {
			$response = [
				'code' => self::EXIT_ERROR,
				'message' => 'Missing Required Params'
			];
		} elseif ($signature !== $validSign) {
			$response = [
				'code' => self::EXIT_USER_INPUT,
				'message' => 'Access Signature invalid '
			];
			if ($username === $authUsername) {
				$response['validSign'] = $validSign;
			}
		} elseif (!isset($parseUrl['host'])) {
			$response = [
				'code' => self::EXIT_USER_INPUT,
				'message' => 'Input URL Not Valid'
			];
		} else {
			if (!empty($with) && $with === 'basic') {
				$res = file_get_contents($url);
			} else {
				try {
					$client = new Client();
					$clientOptions = array();
					if (strtoupper($disabled_verify) === 'YES') {
						$clientOptions['verify'] = false;
					}
					if (!empty($http_headers)) {
						$clientOptions['headers'] = json_decode($http_headers, true);
					}
					if (!empty($allow_redirects)) {
						$clientOptions['allow_redirects'] = json_decode($allow_redirects, true);
					}
					if (!empty($http_auth)) {
						$clientOptions['auth'] = json_decode($http_auth, true);
					}
					if (!empty($http_body)) {
						$clientOptions['body'] = json_decode($http_body, true);
					}
					if (!empty($http_version)) {
						$clientOptions['version'] = $http_version;
					}
					if (!empty($http_query)) {
						$clientOptions['query'] = json_decode($http_query, true);
					}
					if (!empty($http_json)) {
						$clientOptions['json'] = json_decode($http_json, true);
					}
					if (!empty($form_params)) {
						$clientOptions['form_params'] = json_decode($form_params, true);
					}
					if (!empty($form_multipart)) {
						$clientOptions['multipart'] = json_decode($form_multipart, true);
					}
					if (!empty($timeout)) {
						$clientOptions['timeout'] = $timeout;
					}
					if (!empty($http_proxy)) {
						$clientOptions['proxy'] = $http_proxy;
					}
					$request = $client->request($method, $url, $clientOptions);
					$res = $request->getBody();
				} catch (GuzzleException $exception) {
					$res = null;
				}
			}

			$response = array(
				'status' => self::EXIT_SUCCESS,
				'message' => 'OK',
				'data' => $res
			);
		}

		$this->response = $response;
		return $this;
	}
}
