<?php

/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/16/2021
 * Time: 18:00
 */
if (!function_exists('generate_uuid_v4')) {
    /**
     * Function generate_uuid_v4
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/11/2021 52:37
     */
    function generate_uuid_v4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), // 32 bits for "time_low"
            mt_rand(0, 0xffff), // 16 bits for "time_mid"
            mt_rand(0, 0xffff), // 16 bits for "time_hi_and_version",

            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000, // 16 bits, 8 bits for "clk_seq_hi_res",

            // 8 bits for "clk_seq_low",

            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000, // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
// ~~~~~ Blogspot
if (!function_exists('blogspotDescSort')) {
    function blogspotDescSort($item1, $item2): int
    {
        if ($item1['published']['$t'] === $item2['published']['$t']) {
            return 0;
        }

        return ($item1['published']['$t'] < $item2['published']['$t']) ? 1 : -1;
    }
}
if (!function_exists('blogspotUSort')) {
    function blogspotUSort($data)
    {
        usort($data, 'blogspotDescSort');

        return $data;
    }
}
// ~~~~~ Utils
if (!function_exists('short_url_with_tramtro')) {
    /**
     * Function short_url_with_tramtro
     *
     * @param string $longUrl
     *
     * @return bool|string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/09/2020 58:22
     */
    function short_url_with_tramtro(string $longUrl = '')
    {
        if (empty($longUrl)) {
            return '';
        }
        if (!function_exists('config_item') || !function_exists('get_instance')) {
            return '';
        }

        $cms =& get_instance();
        $cms->load->driver('cache', array('adapter' => 'file', 'backup' => 'dummy'));
        $filename = 'go_tramtro_com_url_shortener_' . md5($longUrl);
        $cacheTtl = 2592000;

        if (!$shortUrl = $cms->cache->get($filename)) {
            // Get URL Shortener domain go.tramtro.com
            $shortener = config_item('config_url_shortener');
            $secret = $shortener['token'];
            $timestamp = time();
            $signature = md5($timestamp . $secret);
            $api = $shortener['api'];
            $params = [
                'url' => $longUrl,
                'format' => 'json',
                'action' => 'shorturl',
                'timestamp' => $timestamp,
                'signature' => $signature
            ];
            $request = sendSimpleRequest($api, $params);
            $res = json_decode($request, false);
            if (isset($res->statusCode) && $res->statusCode === 200) {
                $shortUrl = $res->shorturl;
            } else {
                $shortUrl = sendSimpleRequest('https://tinyurl.com/api-create.php?url=' . $longUrl);
            }
            $cms->cache->save($filename, $shortUrl, $cacheTtl);
        }

        return $shortUrl;
    }
}
if (!function_exists('getDailyRandomQuote')) {
    /**
     * Function getDailyRandomQuote
     *
     * @return string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/13/2021 28:25
     */
    function getDailyRandomQuote()
    {
        if (!function_exists('config_item')) {
            return null;
        }
        $result = null;
        $config = config_item('external_api');
        $apis = $config['thudo_api_content_v3'];
        $url = $apis['hostname'] . $apis['apis']['getRandomDanhNgon'];
        $params = array(
            'txtData' => 1,
            'contentId' => 1,
            'totalRecord' => 1,
            'signature' => hash('sha256', 1 . $apis['prefix'] . $apis['token'])
        );
        $request = sendSimpleRequest($url, $params);
        $res = json_decode($request, false);
        if (isset($res->status) && $res->status === 0) {
            $result = $res->data->content;
        }

        return $result;
    }
}
