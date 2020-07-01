<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    'handler' => [
        'http' => [
            //\Hyperf\Validation\ValidationExceptionHandler::class, //验证器异常处理器
            App\Exception\Handler\ValidationCustomExceptionHandler::class, //自定义验证器异常处理器
            App\Exception\Handler\AppExceptionHandler::class,
        ],
    ],
];
