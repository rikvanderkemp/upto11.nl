<?php
declare(strict_types=1);

namespace App\Content\Task;

use App\Content\Config;

interface Task
{
    public function run(Config $config): void;
}
