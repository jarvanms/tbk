<?php

namespace App\Task;

use Hyperf\Di\Annotation\Inject;

/**
 * 定时任务示例.
 */
class FooTask
{
    /**
     * @Inject()
     *
     * @var \Hyperf\Contract\StdoutLoggerInterface
     */
    private $logger;

    public function execute()
    {
        $this->logger->info(date('Y-m-d H:i:s', time()));
    }
}
