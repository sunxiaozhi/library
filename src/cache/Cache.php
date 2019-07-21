<?php
/**
 * 缓存类
 * User: Administrator
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
     * @var string
     */
    protected $defaultCache;

    protected $buffer;

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);

        if (!empty($config['default'])) {
            $this->setDefaultCache($config['default']);
        }
    }

    /**
     * Set default cache name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setDefaultCache($name)
    {
        $this->defaultCache = $name;

        return $this;
    }

    /**
     * @var \sunxiaozhi\library\cache\Buffer Buffer
     * @return mixed
     */
    public function instance()
    {
        $this->buffer ?: $buffer = new Buffer($this->config);

        return $this->buffer->getBuffer();
    }

}