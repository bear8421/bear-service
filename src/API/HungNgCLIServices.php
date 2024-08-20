<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 27/01/2024
 * Time: 14:58
 */

namespace Bear8421\Bear\Services\API;

use Bear8421\Bear\Services\Environment;
use Bear8421\Bear\Services\Traits\Helper;
use Bear8421\Bear\Services\Traits\Version;

class HungNgCLIServices extends HungNgToolsServices
{
    public function isCLI(): bool
    {
        return php_sapi_name() === 'cli';
    }

    public function textColor($color, $text)
    {
        if (!$this->isCLI()) {
            echo self::CLI_ONLY_MSG;
            return false;
        }
        return $color . $text . "\033[0m";
    }

    public function color($color, $text): string
    {
        if (!$this->isCLI()) {
            return $text;
        }
        return $color . $text . "\033[0m";
    }

    public function echoBreakLine()
    {
        if (!$this->isCLI()) {
            echo self::CLI_ONLY_MSG;
        } else {
            echo "===================================================\n";
        }
    }

    public function echoAuthor()
    {
        if (!$this->isCLI()) {
            echo self::CLI_ONLY_MSG;
        } else {
            echo "\n";
            echo "  _    _                           _   _    _____ \n";
            echo " | |  | |                         | \\ | |  / ____|\n";
            echo " | |__| |  _   _   _ __     __ _  |  \\| | | |  __ \n";
            echo " |  __  | | | | | | '_ \\   / _` | | . ` | | | |_ |\n";
            echo " | |  | | | |_| | | | | | | (_| | | |\\  | | |__| |\n";
            echo " |_|  |_|  \\__,_| |_| |_|  \\__, | |_| \\_|  \\_____|\n";
            echo "                            __/ |                 \n";
            echo "                           |___/                  \n";
            echo "\n";
        }
    }

    public function echoFinishedMessage($scriptName = '')
    {
        if (!$this->isCLI()) {
            echo self::CLI_ONLY_MSG;
        } else {
            echo "\n";
            $this->echoBreakLine();
            echo "Finished " . self::textColor(self::COLOR_GREEN, $scriptName) . " at " . date('Y-m-d H:i:s') . "\n";
            echo self::POWERED_BY . PHP_EOL;
            $this->echoBreakLine();
        }
    }

    public function echoHeaderScript($profileName = '', $scriptName = '', $scriptLocation = ''): self
    {
        if (!$this->isCLI()) {
            echo self::CLI_ONLY_MSG;
        } else {
            $this->echoBreakLine();
            $this->echoAuthor();
            echo $this->textColor(self::COLOR_YELLOW, self::POWERED_BY . "\n");
            echo $this->textColor(self::COLOR_CYAN, $profileName . ' - ' . $scriptName . "\n");
            echo $this->textColor(self::COLOR_GREEN, "Run: " . $scriptLocation . "\n");
            echo "\n";
            $this->echoBreakLine();
        }
        return $this;
    }
}
