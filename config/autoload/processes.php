<?php

declare(strict_types=1);
/*
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    Hyperf\Crontab\Process\CrontabDispatcherProcess::class, //定时任务进程
    //Hyperf\AsyncQueue\Process\ConsumerProcess::class, //异步队列进程
];
