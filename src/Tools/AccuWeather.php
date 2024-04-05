<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 27/01/2024
 * Time: 14:59
 */

namespace Bear8421\Bear\Services\Tools;

use Bear8421\Bear\Services\API\HungNgToolsServices;
use Bear8421\Bear\Services\Traits\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AccuWeather extends HungNgToolsServices
{
	use Response;

	protected $config;

	protected $rawResult = false;


	/**
	 * Function convertFoC - Chuyển từ độ F sang độ C
	 *
	 * @param  int  $F
	 *
	 * @return string
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/01/2021 25:11
	 */
	public function convertFoC(int $F = 1): string
	{
		$C = ($F - 32) / 1.8;
		return number_format($C);
	}

	/**
	 * Function setConfig
	 *
	 * @param  array  $config
	 * User: 713uk13m <dev@nguyenanhung.com>
	 * Copyright: 713uk13m <dev@nguyenanhung.com>
	 * @return $this
	 */
	public function setConfig(array $config = array()): AccuWeather
	{
		$this->config = $config;
		return $this;
	}

	public function rawResult($rawResult = true): AccuWeather
	{
		$this->rawResult = $rawResult;
		return $this;
	}

	/**
	 * Function getLastWeather
	 *
	 * User: 713uk13m <dev@nguyenanhung.com>
	 * Copyright: 713uk13m <dev@nguyenanhung.com>
	 * @return $this
	 */
	public function getLastWeather(): AccuWeather
	{
		if ( ! isset($this->config['accessKey']) || ! isset($this->config['language']) || ! isset($this->config['endpoint'])) {
			$this->response = array(
				'error' => true,
				'message' => 'Missing Configure'
			);
			return $this;
		}
		$client = new Client();
		try {
			$params = array(
				'apikey' => $this->config['accessKey'],
				'language' => $this->config['language']
			);
			$request = $client->get($this->config['endpoint'] . '?' . http_build_query($params));
			$resource = $request->getBody();
			$res = json_decode($resource);
			$forecasts = $res->DailyForecasts;
			$headline = $res->Headline;
			$message = [
				'fallback' => 'Thông tin thời tiết 5 ngày tới',
				'text' => 'Thông tin thời tiết 5 ngày tới',
				'color' => '#36a64f',
				'headline' => [
					'EffectiveDate' => $headline->EffectiveDate ?? '',
					'EffectiveEpochDate' => $headline->EffectiveEpochDate ?? '',
					'Severity' => $headline->Severity ?? '',
					'Text' => $headline->Text ?? '',
					'Category' => $headline->Category ?? '',
					'EndDate' => $headline->EndDate ?? '',
					'EndEpochDate' => $headline->EndEpochDate ?? '',
					'MobileLink' => $headline->MobileLink ?? '',
					'Link' => $headline->Link ?? '',
				],
				'fields' => [
					[
						'title' => date('Y-m-d', $forecasts[0]->EpochDate),
						'value' => 'Min: ' . $this->convertFoC(
								$forecasts[0]->Temperature->Minimum->Value
							) . ' | Max: ' . $this->convertFoC(
								$forecasts[0]->Temperature->Maximum->Value
							) . ' | Ngày: ' . $forecasts[0]->Day->IconPhrase . ' | Đêm: ' . $forecasts[0]->Night->IconPhrase,
						'short' => true,
					],
					[
						'title' => date('Y-m-d', $forecasts[1]->EpochDate),
						'value' => 'Min: ' . $this->convertFoC(
								$forecasts[1]->Temperature->Minimum->Value
							) . ' | Max: ' . $this->convertFoC(
								$forecasts[1]->Temperature->Maximum->Value
							) . ' | Ngày: ' . $forecasts[1]->Day->IconPhrase . ' | Đêm: ' . $forecasts[1]->Night->IconPhrase,
						'short' => true,
					],
					[
						'title' => date('Y-m-d', $forecasts[2]->EpochDate),
						'value' => 'Min: ' . $this->convertFoC(
								$forecasts[2]->Temperature->Minimum->Value
							) . ' | Max: ' . $this->convertFoC(
								$forecasts[2]->Temperature->Maximum->Value
							) . ' | Ngày: ' . $forecasts[2]->Day->IconPhrase . ' | Đêm: ' . $forecasts[2]->Night->IconPhrase,
						'short' => true,
					],
					[
						'title' => date('Y-m-d', $forecasts[3]->EpochDate),
						'value' => 'Min: ' . $this->convertFoC(
								$forecasts[3]->Temperature->Minimum->Value
							) . ' | Max: ' . $this->convertFoC(
								$forecasts[3]->Temperature->Maximum->Value
							) . ' | Ngày: ' . $forecasts[3]->Day->IconPhrase . ' | Đêm: ' . $forecasts[3]->Night->IconPhrase,
						'short' => true,
					],
					[
						'title' => date('Y-m-d', $forecasts[4]->EpochDate),
						'value' => 'Min: ' . $this->convertFoC(
								$forecasts[4]->Temperature->Minimum->Value
							) . ' | Max: ' . $this->convertFoC(
								$forecasts[4]->Temperature->Maximum->Value
							) . ' | Ngày: ' . $forecasts[4]->Day->IconPhrase . ' | Đêm: ' . $forecasts[4]->Night->IconPhrase,
						'short' => true,
					],
				],
			];
			// For Telegram
			$telegramMessage = "Bản tin dự báo thời tiết khu vực Hà Nội 05 ngày tới \n";
			$telegramMessage .= "\n" . $message['fields'][0]['title'] . " | " . $message['fields'][0]['value'];
			$telegramMessage .= "\n" . $message['fields'][1]['title'] . " | " . $message['fields'][1]['value'];
			$telegramMessage .= "\n" . $message['fields'][2]['title'] . " | " . $message['fields'][2]['value'];
			$telegramMessage .= "\n" . $message['fields'][3]['title'] . " | " . $message['fields'][3]['value'];
			$telegramMessage .= "\n" . $message['fields'][4]['title'] . " | " . $message['fields'][4]['value'];
			$telegramMessage .= "\n\nCập nhật lúc: " . date('H:i:s d/m/Y');
			$this->response = [
				'success' => true,
				'data' => [
					'message' => $message,
					'telegram_message' => $telegramMessage
				],
				'rawResult' => $this->rawResult,
				'raw' => $this->rawResult === true ? $res : null
			];
		} catch (GuzzleException $e) {
			$this->response = array(
				'error' => true,
				'message' => $e->getMessage()
			);
		}
		return $this;
	}
}
