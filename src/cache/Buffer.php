<?php
/**
 * 缓存器（废弃）
 * User: sunxiaozhi
 * Date: 2019/7/21 10:00
 */

namespace sunxiaozhi\library\cache;

use sunxiaozhi\library\cache\config\Config;
use sunxiaozhi\library\cache\cache\Cache;

use RuntimeException;
use sunxiaozhi\library\exception\InvalidArgumentException;

class Buffer
{
    /**
     * @var string
     */
    protected $defaultBuffer;

    /**
     * @var \sunxiaozhi\library\cache\cache $cache
     */
    protected $cache;

    /**
     * @var \sunxiaozhi\library\cache\config\Config $config
     */
    protected $config;

    public function __construct($cache = null, Config $config = null)
    {
        $this->cache = $cache;
        $this->config = $config;

        if (!empty($config['default'])) {
            $this->setDefaultBuffer($config['default']);
        }
    }

    /**
     * Set default buffer name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setDefaultBuffer($name)
    {
        $this->defaultBuffer = $name;

        return $this;
    }

    /**
     * Get buffer
     *
     * @param string $name
     *
     * @return Cache
     *
     * @throws InvalidArgumentException
     */
    public function getBuffer()
    {
        $name = $this->defaultBuffer ?: $this->getDefaultBuffer();

        return $this->createBuffer($name);
    }

    /**
     * Get default buffer name.
     *
     * @return string
     *
     * @throws \RuntimeException if no default gateway configured
     */
    public function getDefaultBuffer()
    {
        if (empty($this->defaultBuffer)) {
            throw new RuntimeException('No default buffer configured.');
        }

        return $this->defaultBuffer;
    }

    /**
     * Create buffer
     *
     * @param $name
     * @return Cache
     * @throws InvalidArgumentException
     */
    public function createBuffer($name)
    {
        $className = $this->formatBufferClassName($name);
        $buffer = $this->makeBuffer($className, $this->config);


        if (!($buffer instanceof Cache)) {
            throw new InvalidArgumentException(\sprintf('Buffer "%s" must implement interface %s.', $name, Cache::class));
        }

        return $buffer;
    }

    /**
     * Formate buffer class name
     *
     * @param $name
     *
     * @return string
     */
    protected function formatBufferClassName($name)
    {
        /*if (\class_exists($name) && \in_array(Cache::class, \class_implements($name))) {
            return $name;
        }*/

        $name = \ucfirst(\str_replace(['-', '_', ''], '', $name));

        return __NAMESPACE__ . "\\cache\\{$name}";
    }

    /**
     * Make cache instance.
     *
     * @param string $buffer
     * @param array $config
     *
     * @return \sunxiaozhi\library\cache\cache\Cache
     *
     * @throws \sunxiaozhi\library\exception\InvalidArgumentException
     */
    protected function makeBuffer($buffer, Config $config)
    {
        /*if (!\class_exists($buffer) || !\in_array(Cache::class, \class_implements($buffer))) {
            throw new InvalidArgumentException(\sprintf('Class "%s" is a invalid easy-sms gateway.', $buffer));
        }*/

        if (!\class_exists($buffer)) {
            throw new InvalidArgumentException(\sprintf('Class "%s" is a invalid cache.', $buffer));
        }

        return new $buffer($config);
    }
}