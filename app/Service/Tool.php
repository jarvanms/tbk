<?php

namespace App\Service;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Logger\LoggerFactory;

/**
 * 工具类
 * Class Tool.
 */
class Tool
{
    /**
     * 产生唯一字符串.
     *
     * @param bool $md5
     *
     * @return string
     */
    public static function uniqueStr($md5 = false)
    {
        $serverName       = $_SERVER['SERVER_NAME'] ?? 'cnsthai.com';
        $serverAddr       = $_SERVER['SERVER_ADDR'] ?? '127.0.0.1';
        $address          = strtolower($serverName . '/' . $serverAddr);
        list($usec, $sec) = explode(' ', microtime());
        $timeMillis       = $sec . substr($usec, 2, 3);
        $tmp              = rand(0, 1) ? '-' : '';
        $random           = $tmp . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999) . rand(100, 999) . rand(100, 999);
        $valueBeforeMD5   = $address . ':' . $timeMillis . ':' . $random;
        $value            = md5($valueBeforeMD5);
        $raw              = strtolower($value);
        $result           = substr($raw, 0, 8) . '-' . substr($raw, 8, 4) . '-' . substr($raw, 12, 4) . '-' . substr($raw, 16, 4) . '-' . substr($raw, 20);

        return (true === $md5) ? md5($result) : $result;
    }

    /**
     * 将二维数组转为一维数组.
     *
     * @param $arr
     * @param $key
     * @param $value
     *
     * @return array
     */
    public static function arrayKeyToValue($arr, $key, $value)
    {
        return array_combine(array_column($arr, $key), array_column($arr, $value));
    }

    /**
     * 获取若干个数组的任意组合.
     *
     * @param $arr [[1, 2, 3], [4, 5, 6], ['a', 'b', 'c']]
     *
     * @return mixed
     */
    public static function doExchange($arr)
    {
        $len = count($arr);
        if ($len >= 2) {
            // 第一个数组的长度
            $len1 = count($arr[0]);
            // 第二个数组的长度
            $len2 = count($arr[1]);
            //  申明一个新数组
            $items = [];
            // 申明新数组的索引
            $index = 0;
            for ($i = 0; $i < $len1; $i++) {
                for ($j = 0; $j < $len2; $j++) {
                    if (is_array($arr[0][$i])) {
                        $items[$index] = array_merge($arr[0][$i], is_array($arr[1][$j]) ? $arr[1][$j] : [$arr[1][$j]]);
                    } else {
                        $items[$index] = array_merge([$arr[0][$i]], is_array($arr[1][$j]) ? $arr[1][$j] : [$arr[1][$j]]);
                    }
                    $index++;
                }
            }
            $newArr = [];
            for ($i = 2; $i < count($arr); $i++) {
                $newArr[$i - 1] = $arr[$i];
            }
            $newArr[0] = $items;

            return self::doExchange($newArr);
        }

        return $arr[0];
    }

    /**
     * @param $arr
     *
     * @return string
     */
    public static function getSkuStr($arr)
    {
        sort($arr);

        return implode('_', $arr);
    }

    /**
     * 截取字符串.
     *
     * @param $str
     * @param $length
     *
     * @return string
     */
    public static function mbSubStr($str, $length)
    {
        $suffix = mb_strlen($str) > $length ? '...' : '';

        return mb_substr($str, 0, $length) . $suffix;
    }

    /**
     * 将数字转为四舍五入，保留两位小数.
     *
     * @param float $floatNumber 未经过四舍五入的float数字
     * @param int   $pos         保留位数
     *
     * @return float
     **/
    public static function handleCurrency($floatNumber, $pos = 2)
    {
        return sprintf("%.{$pos}f", round($floatNumber, $pos));
    }

    /**
     * 生成url.
     *
     * @param string $action
     * @param array  $params
     *
     * @return string
     */
    public static function urlTo(string $action, array $params = [])
    {
        if (!empty($params)) {
            $paramsStr = http_build_query($params);
            $url       = $action . '?' . $paramsStr;
        } else {
            $url = $action;
        }

        return $url;
    }

    /**
     * 加密密码
     *
     * @param string $password
     *
     * @return string
     */
    public static function encryptPassword(string $password)
    {
        return md5($password . '_hf_system');
    }

    /**
     * 随机数生成.
     *
     * @param int $length
     *
     * @return string
     */
    public static function generateRandomString($length = 10)
    {
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    /**
     * 会话id创建.
     *
     * @return string
     */
    public static function createSessionId()
    {
        return uniqid() . self::generateRandomString(7);
    }

    /**
     * 生成分页参数$urlPattern，页码get参数为page.
     *
     * @param RequestInterface $request
     *
     * @return string
     */
    public static function getUrlPattern(RequestInterface $request)
    {
        $getParams         = $request->query();
        $getParams['page'] = 'PAGE_NUMBER';
        $url               = self::urlTo($request->getRequestUri(), $getParams);
        $url               = str_replace('PAGE_NUMBER', '(:num)', $url);

        return $url;
    }

    /**
     * 获取日志操作类.
     *
     * @param string $group
     *
     * @return \Psr\Log\LoggerInterface
     */
    public static function getLogger($group = 'default')
    {
        $container = \Hyperf\Utils\ApplicationContext::getContainer();

        return $container->get(LoggerFactory::class)->get('log', $group);
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public static function getLoggerSystem()
    {
        return self::getLogger('system');
    }

    /**
     * 获取控制器名称.
     *
     * @param RequestInterface $request
     *
     * @return string
     */
    public static function getControllerName(RequestInterface $request)
    {
        $path    = $request->getPathInfo();
        $pathArr = explode('/', $path);

        return (string) $pathArr[2];
    }

    /**
     * 获取操作名称.
     *
     * @param RequestInterface $request
     *
     * @return string
     */
    public static function getActionName(RequestInterface $request)
    {
        $path    = $request->getPathInfo();
        $pathArr = explode('/', $path);

        return (string) $pathArr[3];
    }

    /**
     * 判断是否为ajax请求
     *
     * @param RequestInterface $request
     *
     * @return bool
     */
    public static function isAjax(RequestInterface $request)
    {
        $header = $request->getHeader('X-Requested-With');
        if (!empty($header[0]) && 'XMLHttpRequest' == $header[0]) {
            return true;
        }

        return false;
    }

    /**
     * 获取图片html显示路径.
     *
     * @param string $relativeFilePath
     *
     * @return string
     */
    public static function imgHtmlPath(string $relativeFilePath)
    {
        return '/upload/' . $relativeFilePath;
    }

    /**
     * 获取上传文件的绝对路径.
     *
     * @param string $relativeFilePath
     *
     * @return string
     */
    public static function getFileAbsolutePath(string $relativeFilePath)
    {
        return BASE_PATH . '/public/upload/' . $relativeFilePath;
    }
}
