<?php
/**
 * 缓存类
 * User: sunxiaozhi
 * Date: 2019/7/21 9:14
 */

namespace sunxiaozhi\library\cache;

use sunxiaozhi\library\cache\config\Config;
use RuntimeException;
use sunxiaozhi\library\exception\InvalidArgumentException;

class Cache
{
    /**
     * @var \sunxiaozhi\library\cache\config\Config
     */
    protected $config;

    /**
     * @var \sunxiaozhi\library\cache\Cache $cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $defaultCache;

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
     * Cache instance
     *
     * @return \sunxiaozhi\library\cache\Cache Cache
     *
     * @throws InvalidArgumentException
     */
    public function instance()
    {
        return $this->getCache();
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
     * Get cache
     *
     * @param string $name
     *
     * @return Cache
     *
     * @throws InvalidArgumentException
     */
    public function getCache()
    {
        $name = $this->defaultCache ?: $this->getDefaultCache();

        return $this->createCache($name);
    }

    /**
     * Get default cache name.
     *
     * @return string
     *
     * @throws \RuntimeException if no default gateway configured
     */
    public function getDefaultCache()
    {
        if (empty($this->defaultCache)) {
            throw new RuntimeException('No default cache configured.');
        }

        return $this->defaultCache;
    }

    /**
     * Create cache
     *
     * @param $name
     * @return Cache
     * @throws InvalidArgumentException
     */
    public function createCache($name)
    {
        $className = $this->formatCacheClassName($name);
        $cache = $this->makeCache($className);


        if (!($cache instanceof Cache)) {
            throw new InvalidArgumentException(\sprintf('Cache "%s" must implement interface %s.', $name, Cache::class));
        }

        return $cache;
    }

    /**
     * Formate cache class name
     *
     * @param $name
     *
     * @return string
     */
    protected function formatCacheClassName($name)
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
     * @param string $cache
     * @param array $config
     *
     * @return \sunxiaozhi\library\cache\cache\Cache
     *
     * @throws \sunxiaozhi\library\exception\InvalidArgumentException
     */
    protected function makeCache($cache)
    {
        /*if (!\class_exists($cache) || !\in_array(Cache::class, \class_implements($cache))) {
            throw new InvalidArgumentException(\sprintf('Class "%s" is a invalid easy-sms gateway.', $cache));
        }*/

        if (!\class_exists($cache)) {
            throw new InvalidArgumentException(\sprintf('Class "%s" is a invalid cache.', $cache));
        }

        return new $cache($this->config);
    }

}