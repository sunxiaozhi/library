<?php
/**
 * 缓存类
 * User: sunxiaozhi
 * Date: 2019/7/21 9:14
 */

namespace sunxiaozhi\library\cache;

use sunxiaozhi\library\cache\config\Config;

class Cache
{
    /**
     * @var \sunxiaozhi\library\cache\config\Config
     */
    protected $config;

    /**
     * @var \sunxiaozhi\library\cache\Buffer $buffer
     */
    protected $buffer;

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * Cache instance
     *
     * @var \sunxiaozhi\library\cache\Buffer Buffer
     *
     * @return \sunxiaozhi\library\cache\cache\Cache
     *
     * @throws \sunxiaozhi\library\exception\InvalidArgumentException
     */
    public function instance()
    {
        $this->buffer = $this->buffer ? $this->buffer : $buffer = new Buffer($this, $this->config);

        return $this->buffer->getBuffer();
    }

}