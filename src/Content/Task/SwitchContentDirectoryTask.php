<?php
declare(strict_types=1);

namespace App\Content\Task;

use App\Content\Config;
use Symfony\Component\Filesystem\Filesystem;

class SwitchContentDirectoryTask implements Task
{
    public function run(Config $config): void
    {
        $fileSystem = new Filesystem();
        $fileSystem->rename(rtrim($config->processDir, '/'), rtrim($config->finalDir, '/'), true);
    }
}
