<?php
/**
 * Memcache
 * User: sunxiaozhi
 * Date: 2019/7/22 11:19
 */

namespace sunxiaozhi\library\cache\cache;

use sunxiaozhi\library\cache\config\Config;

class MemCache extends Cache
{
    /**
     * Constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {

    }

    public function has($name)
    {
        // TODO: Implement has() method.
    }

    public function get($name, $default = false)
    {
        // TODO: Implement get() method.
    }

    public function set($name, $value, $expire = null)
    {
        // TODO: Implement set() method.
    }

    public function inc($name, $step = 1)
    {
        // TODO: Implement inc() method.
    }

    public function dec($name, $step = 1)
    {
        // TODO: Implement dec() method.
    }

    public function delete($name)
    {
        // TODO: Implement delete() method.
    }

    public function flush($tag = null)
    {
        // TODO: Implement flush() method.
    }

}