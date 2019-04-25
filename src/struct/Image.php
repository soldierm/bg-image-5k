<?php
declare(strict_types=1);

namespace bg\struct;

class Image
{
    /**
     * 宽度
     *
     * @var string
     */
    public $width = '';

    /**
     * 高度
     *
     * @var string
     */
    public $height = '';

    /**
     * 颜色
     *
     * @var string
     */
    public $color = '';

    /**
     * 描述
     *
     * @var string
     */
    public $description = '';

    /**
     * 下载路径
     *
     * @var Urls
     */
    public $urls = '';

    /**
     * 下载
     *
     * @param int type
     * @return void
     */
    public function download(int $type): void
    {
        $this->urls->download($type);
    }
}