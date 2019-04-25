<?php
declare(strict_types=1);

namespace bg\struct;

use bg\Instance;
use bg\Spider;

class Urls
{
    /**
     * 未加工图片
     *
     * @var string
     */
    public $raw;

    /**
     * 完整图片
     *
     * @var string
     */
    public $full;

    /**
     * 普通照片
     *
     * @var string
     */
    public $regular;

    /**
     * 小图
     *
     * @var string
     */
    public $small;

    /**
     * 缩略图
     *
     * @var string
     */
    public $thumb;

    /**
     * 下载
     *
     * @param int $type
     * @return void
     */
    public function download(int $type): void
    {
        $file = $this->getDownloadPath($type) . time() . '.jpg';
        @touch($file);
        Instance::getClient()->get($this->raw, ['sink' => $file]);
    }

    /**
     * 获取
     *
     * @param int $type
     * @return string
     */
    private function getDownloadPath(int $type): string
    {
        $path = ROOT_PATH . '/download/' . $this->getDirByType($type) . '/' . date('Ymd') . '/';
        @mkdir($path, 0777, true);

        return $path;
    }

    /**
     * 获取目录名
     *
     * @param int $type
     * @return mixed
     */
    private function getDirByType(int $type): string
    {
        $dir = [
            Spider::TYPE_NEW => 'new',
            Spider::TYPE_HOT => 'hot',
            Spider::TYPE_GIRL => 'girl',
            Spider::TYPE_SKY => 'sky'
        ];

        return $dir[$type];
    }
}