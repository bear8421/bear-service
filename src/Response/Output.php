<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/16/2021
 * Time: 18:00
 */

namespace Bear8421\Bear\Services\Response;

/**
 * Class Output
 *
 * @package   Bear8421\Bear\Services\Response
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Output
{
    /**
     * Function writeLn
     *
     * @param string|int|array|object $message
     * @param string                  $newLine
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/16/2021 01:19
     */
    public static function writeLn($message, string $newLine = "\n")
    {
        if (is_array($message) || is_object($message)) {
            $message = json_encode($message);
        }
        echo $message . $newLine;
    }
}
