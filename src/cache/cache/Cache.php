<?php
/**
 * Cache
 * User: sumxiaozhi
 * Date: 2019/7/21 17:15
 */

namespace sunxiaozhi\library\cache\cache;

abstract class Cache
{
    /**
     * @var mixed
     */
    protected $handler;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $tag;

    /**
     * 判断缓存是否存在
     *
     * @access public
     *
     * @param string $name 缓存变量名
     *
     * @return bool
     */
    abstract public function has($name);

    /**
     * 读取缓存
     *
     * @access public
     *
     * @param string $name 缓存变量名
     * @param mixed  $default 默认值
     *
     * @return mixed
     */
    abstract public function get($name, $default = false);

    /**
     * 写入缓存
     *
     * @access public
     *
     * @param string    $name 缓存变量名
     * @param mixed     $value  存储数据
     * @param int       $expire  有效时间 0为永久
     *
     * @return boolean
     */
    abstract public function set($name, $value, $expire = null);

    /**
     * 自增缓存（针对数值缓存）
     *
     * @access public
     *
     * @param string    $name 缓存变量名
     * @param int       $step 步长
     *
     * @return false|int
     */
    abstract public function inc($name, $step = 1);

    /**
     * 自减缓存（针对数值缓存）
     *
     * @access public
     *
     * @param string    $name 缓存变量名
     * @param int       $step 步长
     *
     * @return false|int
     */
    abstract public function dec($name, $step = 1);

    /**
     * 删除缓存
     *
     * @access public
     *
     * @param string $name 缓存变量名
     *
     * @return boolean
     */
    abstract public function rm($name);

    /**
     * 清除缓存
     *
     * @access public
     *
     * @param string $tag 标签名
     *
     * @return boolean
     */
    abstract public function clear($tag = null);

    /**
     * 更新标签
     *
     * @access public
     *
     * @param string $name 缓存标识
     *
     * @return void
     */
    protected function setTagItem($name)
    {
        if ($this->tag) {
            $key       = 'tag_' . md5($this->tag);
            $this->tag = null;
            if ($this->has($key)) {
                $value   = explode(',', $this->get($key));
                $value[] = $name;
                $value   = implode(',', array_unique($value));
            } else {
                $value = $name;
            }
            $this->set($key, $value, 0);
        }
    }

    /**
     * 获取标签包含的缓存标识
     *
     * @access public
     *
     * @param string $tag 缓存标签
     *
     * @return array
     */
    protected function getTagItem($tag)
    {
        $key   = 'tag_' . md5($tag);
        $value = $this->get($key);
        if ($value) {
            return array_filter(explode(',', $value));
        } else {
            return [];
        }
    }

    /**
     * 获取实际的缓存标识
     *
     * @access public
     *
     * @param string $name 缓存名
     *
     * @return string
     */
    protected function getCacheKey($name)
    {
        return $this->options['prefix'] . $name;
    }

}