<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/16/2021
 * Time: 16:25
 */

namespace Bear8421\Bear\Services;

/**
 * Interface Environment
 *
 * @package   Bear8421\Bear\Services
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface Environment
{
    const VERSION = '1.3.2';
    const POWERED_BY = 'Powered by Hung Nguyen - hungna.dev@gmail.com';
    const POWERED_BY_NAME = 'Hung Nguyen';
    const POWERED_BY_EMAIL = 'hungna.dev@gmail.com';
    const COLOR_NC = "\033[0m";
    const COLOR_GREEN = "\033[0;32m";
    const COLOR_YELLOW = "\033[0;33m";
    const COLOR_CYAN = "\033[0;36m";
    const COLOR_RED = "\033[0;31m";
    const CLI_ONLY_MSG = "This script is only for CLI environment.\n";

    public function getVersion(): string;
}
