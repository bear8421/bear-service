<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 17/8/24
 * Time: 23:10
 */

namespace Bear8421\Bear\Services\Tools;

use Bear8421\Bear\Services\API\HungNgToolsServices;
use InvalidArgumentException;
use Symfony\Component\Filesystem\Filesystem;

class MakeStorage extends HungNgToolsServices
{
    private $filesystem;
    private $whitelistExtensions;

    /**
     * Constructor to initialize Filesystem and allowed file extensions.
     */
    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->whitelistExtensions = [
            'txt',
            'text',
            'log',
            'logs',
            'cache',
            'gitkeep',
            'htaccess',
            'html',
            'htm',
        ];
    }

    /**
     * Creates a directory and specific files inside it if they do not exist.
     * Optionally sets permissions to 777 for the directory and its files.
     *
     * @param string $directoryName The name of the directory to create.
     * @param string|array $filesToCreate Either a string or an array of filenames (with optional contents) to create inside the directory.
     * @param bool $applyChmod Whether to apply chmod 777 to the directory and files.
     * @return void
     */
    public function create(string $directoryName, $filesToCreate = [], bool $applyChmod = false)
    {
        // Create the directory if it doesn't exist
        if (!$this->filesystem->exists($directoryName)) {
            $this->filesystem->mkdir($directoryName);
        }

        // Handle file creation
        if (is_string($filesToCreate)) {
            $this->createFile($directoryName, $filesToCreate);
        } elseif (is_array($filesToCreate)) {
            foreach ($filesToCreate as $filename => $content) {
                $this->createFile($directoryName, $filename, $content);
            }
        }

        // Apply chmod 777 if specified
        if ($applyChmod) {
            $this->filesystem->chmod($directoryName, 0777);
            if (is_string($filesToCreate)) {
                $this->filesystem->chmod($directoryName . DIRECTORY_SEPARATOR . $filesToCreate, 0777);
            } elseif (is_array($filesToCreate)) {
                foreach (array_keys($filesToCreate) as $filename) {
                    $this->filesystem->chmod($directoryName . DIRECTORY_SEPARATOR . $filename, 0777);
                }
            }
        }
    }

    /**
     * Creates a single file within the specified directory.
     * @param string $directoryName
     * @param string $filename
     * @param string $content
     * @return void
     */
    private function createFile(string $directoryName, string $filename, string $content = '')
    {
        if ($this->checkWhitelistFilename($filename)) {
            $filePath = $directoryName . DIRECTORY_SEPARATOR . $filename;
            if (!$this->filesystem->exists($filePath) && !empty($content)) {
                $this->filesystem->dumpFile($filePath, $content);
            }
        } else {
            throw new InvalidArgumentException("File extension not allowed: $filename");
        }
    }

    /**
     * Checks if the file's extension is in the whitelist.
     * @param string $filename
     * @return bool
     */
    private function checkWhitelistFilename(string $filename): bool
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array($extension, $this->whitelistExtensions, true);
    }
}
