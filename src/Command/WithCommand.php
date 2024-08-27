<?php

namespace Bear8421\Bear\Services\Command;

use Bear8421\Bear\Services\Environment;
use Bear8421\Bear\Services\Traits\Version;
use nguyenanhung\Libraries\Filesystem\Filesystem;

class WithCommand implements Environment
{
    use Version;

    public function fileSystem(): Filesystem
    {
        return new Filesystem();
    }

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

    protected function isSuccess(): string
    {
        return $this->color(self::COLOR_YELLOW, 'successfully!');
    }

    protected function isFailed(): string
    {
        return $this->color(self::COLOR_RED, 'failed!');
    }
}
