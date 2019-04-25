<?php
declare(strict_types=1);

namespace bg;

use JsonMapper;
use GuzzleHttp\Client;

class Instance
{
    /**
     * Http客户端
     *
     * @var Client
     */
    private static $client;

    /**
     * 最好用的JsonMapper
     *
     * @var JsonMapper
     */
    private static $jsonMapper;

    /**
     * 获取Http客户端
     *
     * @return Client
     */
    public static function getClient(): Client
    {
        if (!static::$client) {
            static::$client = new Client(['verify' => false]);
        }

        return static::$client;
    }

    /**
     * 一起来用JsonMapper吧
     *
     * @return JsonMapper
     */
    public static function getJsonMapper(): JsonMapper
    {
        if (!static::$jsonMapper) {
            static::$jsonMapper = new JsonMapper();
            static::$jsonMapper->bStrictNullTypes = false;
        }

        return static::$jsonMapper;
    }
}