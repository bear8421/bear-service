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
        $name = $this->color(self::COLOR_GREEN, $path);
        if (empty($path)) {
            echo "Invalid or empty directory path";
            return false;
        }
        if (create_new_folder($path) === true) {
            echo "Create directory: '" . $name . "' " . $this->isSuccess() . PHP_EOL;
            return true;
        } else {
            echo "Create directory: '" . $name . "' " . $this->isFailed() . PHP_EOL;
            return false;
        }
    }

    public function createFileOnDirectory($file, $content = ''): bool
    {
        $name = $this->color(self::COLOR_GREEN, $file);
        if (empty($file)) {
            echo "Invalid or empty file path";
            return false;
        }
        if (file_append($file, $content) === true) {
            echo "Create file: '" . $name . "' " . $this->isSuccess() . PHP_EOL;
            return true;
        } else {
            echo "Create file: '" . $name . "' " . $this->isFailed() . PHP_EOL;
            return false;
        }
    }
}
