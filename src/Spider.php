<?php
declare(strict_types=1);

namespace bg;

use bg\struct\Image;
use function GuzzleHttp\json_decode as guzzle_json_decode;

class Spider
{
    /**
     * 类型：最新
     *
     * @var int
     */
    public const TYPE_NEW = 1;

    /**
     * 类型：最热
     *
     * @var int
     */
    public const TYPE_HOT = 2;

    /**
     * 类型：女生
     *
     * @var int
     */
    public const TYPE_GIRL = 3;

    /**
     * 类型：星空
     *
     * @var int
     */
    public const TYPE_SKY = 4;

    /**
     * 默认采集数量
     *
     * @var int
     */
    private const DEFAULT_NUM = 20;

    /**
     * 采集类型
     *
     * @var int
     */
    private $type = self::TYPE_NEW;

    /**
     * 采集的图片数量
     *
     * @var int
     */
    private $num = self::DEFAULT_NUM;

    /**
     * 下载的图片
     *
     * @var Image[]
     */
    private $images = [];

    /**
     * Spider constructor.
     * @param array $config
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * 下载
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function run(): void
    {
        try {
            $response = Instance::getClient()->get($this->getUrlByType());
            $json = guzzle_json_decode($response->getBody());
            $this->images = Instance::getJsonMapper()->mapArray($json, [], Image::class);
            array_walk($this->images, function (Image $image, $key) {
                $sort = ++$key;
                echo "正在下载第{$sort}张图片...\n";
                $image->download((int)$this->type);
                echo "第{$sort}张图片下载完成...\n";
            });
        } catch (\Exception $exception) {
            exit("{$exception->getMessage()} \n");
        }
    }

    /**
     * 初始化方法
     *
     * @return void
     */
    private function init(): void
    {
        $this->checkSAPIEnv();
        $this->parseCommand();
    }

    /**
     * 校验SAPI环境
     *
     * @return void
     */
    private function checkSAPIEnv(): void
    {
        if (php_sapi_name() != "cli") {
            exit("only run in command line mode \n");
        }
    }

    /**
     * 解析命令
     *
     * @return void
     */
    private function parseCommand(): void
    {
        global $argv;

        $this->type = $argv[1] ?? self::TYPE_NEW;
        $this->num = $argv[2] ?? self::DEFAULT_NUM;
    }

    /**
     * 获取请求地址
     *
     * @return string
     */
    private function getUrlByType(): string
    {
        $urls = [
            self::TYPE_NEW => 'http://service.paper.meiyuan.in/api/v2/columns/flow/5c68ffb9463b7fbfe72b0db0?page=1&per_page=',
            self::TYPE_HOT => 'http://service.paper.meiyuan.in/api/v2/columns/flow/5c69251c9b1c011c41bb97be?page=1&per_page=',
            self::TYPE_GIRL => 'http://service.paper.meiyuan.in/api/v2/columns/flow/5c81087e6aee28c541eefc26?page=1&per_page=',
            self::TYPE_SKY => 'http://service.paper.meiyuan.in/api/v2/columns/flow/5c81f64c96fad8fe211f5367?page=1&per_page=',
        ];

        return $urls[$this->type] . $this->num;
    }
}