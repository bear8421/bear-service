<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 23/09/2023
 * Time: 21:46
 */

namespace Bear8421\Bear\Services\FunnyNews;

use Bear8421\Bear\Services\API\HungNgApiServices;
use Bear8421\Bear\Services\Traits\Helper;
use Bear8421\Bear\Services\Traits\Version;

class FunnyNewsServiceRequest extends HungNgApiServices
{
    use Version, Helper;

    const ENDPOINT = 'https://api.nguyenanhung.com/funny_news/api';

    public function __construct($clientId, $clientPrefix, $secretToken)
    {
        parent::__construct($clientId, $clientPrefix, $secretToken);
    }

    public function handleRequestServiceREST($domain = '')
    {
        if (empty($domain)) {
            $domain = 'https://news.tramtro.com/';
        }
        $signature = md5($this->clientId . '|' . $domain . '|' . $this->secretToken);
        $params = [
            'domain' => $domain,
            'username' => $this->clientId,
            'signature' => $signature
        ];
        $request = sendSimpleRequest(self::ENDPOINT, $params);
        if ($request === null) {
            return [
                'errorMessage' => 'Không request được tới API ' . self::ENDPOINT
            ];
        }
        $res = json_decode($request, false);
        if (isset($res->message) && $res->message === 0) {
            return [
                'message' => $res->message,
                'list_url' => $res->list_url,
            ];
        }
        return [
            'errorMessage' => 'Có lỗi xảy ra khi lấy dữ liệu tại API ' . self::ENDPOINT
        ];
    }

    public function handleRequestServiceSitemapIndex($domain = '')
    {
        $funnyDomain = 'https://news.tramtro.com/';
        if ($domain === $funnyDomain) {
            $sitemapCategoryIndex = $domain . 'sitemap/request-category.xml';
        } else {
            $sitemapCategoryIndex = $domain . 'sitemap/category.xml';
        }
        $reqMapCategoryIndex = sendSimpleRequest($sitemapCategoryIndex);
        $resMapCategoryIndex = simplexml_load_string($reqMapCategoryIndex, 'SimpleXMLElement', LIBXML_NOCDATA);
        unset($reqMapCategoryIndex);
        return $resMapCategoryIndex;
    }
}
