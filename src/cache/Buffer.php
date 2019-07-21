<?php
/**
 * 缓存器
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
    protected $buffer;

    protected $defaultBuffer;

    protected $defaultCache;

    /**
     * @var \sunxiaozhi\library\cache\cache $cache
     */
    protected $cache;

    protected $config;

    public function __construct($cache = null, Config $config = null)
    {
        $this->cache = $cache;
        $this->config = $config;

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
     * @param $name
     * @return Cache
     * @throws InvalidArgumentException
     */
    public function getBuffer()
    {
        $name = $this->defaultCache ?: $this->getDefaultBuffer();

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
     * @param $name
     * @return Cache
     * @throws InvalidArgumentException
     */
    public function createBuffer($name)
    {
        $className = $this->formatBufferClassName($name);
        $buffer = $this->makeBuffer($className, $this->config->get("cache.{$name}", []));


        if (!($buffer instanceof Cache)) {
            throw new InvalidArgumentException(\sprintf('Buffer "%s" must implement interface %s.', $name, Cache::class));
        }

        return $buffer;
    }

    protected function formatBufferClassName($name)
    {
        /*if (\class_exists($name) && \in_array(Cache::class, \class_implements($name))) {
            return $name;
        }*/

        $name = \ucfirst(\str_replace(['-', '_', ''], '', $name));

        return __NAMESPACE__ . "\\cache\\{$name}";
    }

    /**
     * Make gateway instance.
     *
     * @param string $buffer
     * @param array $config
     *
     * @return \sunxiaozhi\library\cache\cache\Cache
     *
     * @throws \sunxiaozhi\library\exception\InvalidArgumentException
     */
    protected function makeBuffer($buffer, $config)
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