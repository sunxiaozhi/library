<?php
/**
 *
 * User: Administrator
 * Date: 2019/7/21 8:30
 */

namespace sunxiaozhi\library\cache\contracts;

interface CacheInterface
{
    /**
     *
     * @return mixed
     */
    public function connnect();

    public function get();

    public function set();

    public function delete();
}