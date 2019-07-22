Personal library

验证码生成类

Curl请求类

缓存类

* Redis
```php
$config = [
    'default' => 'redis',
    'cache' => [
        'redis' => [
            'host' => '127.0.0.1',
            'password' => '',
            'port' => '6379',
        ]
    ]
];

try {
    $cache = new Cache($config);
    $cacheInstance = $cache->instance();
    $cacheInstance->set('a', 'abcd', 50);
    $cacheInstance->set('b', ['adcd'], 50);
    $cacheInstance->set('c', 10, 50);
    var_dump($cacheInstance->get('a'));
    var_dump($cacheInstance->get('b'));
    var_dump($cacheInstance->get('c'));
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
```
* Memcache