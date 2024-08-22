<?php

namespace Bear8421\Bear\Services\Command;

class CreateDirectoryCommand extends WithCommand
{
    public function chmod($path, $mode = 0777)
    {
        $this->fileSystem()->chmod($path, $mode, 0000, true);
    }

    public function createDirectory($path): bool
    {
        if (empty($path)) {
            echo "Invalid or empty directory path";
            return false;
        }
        if (create_new_folder($path) === true) {
            echo "Create directory: '" . $this->color(self::COLOR_GREEN, $path) . "' " . $this->color(
                    self::COLOR_YELLOW,
                    'successfully!'
                ) . PHP_EOL;
            return true;
        } else {
            echo "Create directory: '" . $this->color(self::COLOR_GREEN, $path) . "' " . $this->color(
                    self::COLOR_RED,
                    'failed!'
                ) . PHP_EOL;
            return false;
        }
    }

    public function createFileOnDirectory($file, $content = ''): bool
    {
        if (empty($file)) {
            echo "Invalid or empty file path";
            return false;
        }
        if (file_append($file, $content) === true) {
            echo "Create file: '" . $this->color(self::COLOR_GREEN, $file) . "' " . $this->color(
                    self::COLOR_YELLOW,
                    'successfully!'
                ) . PHP_EOL;
            return true;
        } else {
            echo "Create file: '" . $this->color(self::COLOR_GREEN, $file) . "' " . $this->color(
                    self::COLOR_RED,
                    'failed!'
                ) . PHP_EOL;
            return false;
        }
    }
}
