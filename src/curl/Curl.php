<?php
/**
 * Curl
 * User: sunxiaozhi
 * Date: 2018/6/4 15:48
 */

namespace sunxiaozhi\library\curl;

class Curl
{
    /**
     * POST请求
     *
     * @access public
     *
     * @param $url //地址
     * @param string $fields //附带参数，可以是数组，也可以是字符串
     * @param string $userAgent //浏览器UA
     * @param string $httpHeaders //header头部，数组形式
     * @param string $username //用户名
     * @param string $password //密码
     *
     * @return boolean
     */
    public function post($url, $fields, $userAgent = '', $httpHeaders = '', $username = '', $password = '')
    {
        $return = $this->execute('POST', $url, $fields, $userAgent, $httpHeaders, $username, $password);

        if (false === $return || is_array($return)) {
            return false;
        }

        return $return;
    }

    /**
     * GET请求
     *
     * @access public
     *
     * @param $url //地址
     * @param string $userAgent //浏览器UA
     * @param string $httpHeaders //header头部，数组形式
     * @param string $username //用户名
     * @param string $password //密码
     *
     * @return array|bool|mixed
     */
    public function get($url, $userAgent = '', $httpHeaders = '', $username = '', $password = '')
    {
        $return = $this->execute('GET', $url, "", $userAgent, $httpHeaders, $username, $password);

        if (false === $return || is_array($return)) {
            return false;
        }

        return $return;
    }

    /**
     * Curl请求
     *
     * @access private
     *
     * @param $method //请求方式
     * @param $url //地址
     * @param string $fields //附带参数，可以是数组，也可以是字符串
     * @param string $userAgent //浏览器UA
     * @param string $httpHeaders //header头部，数组形式
     * @param string $username //用户名
     * @param string $password //密码
     *
     * @return array|bool|mixed
     */
    private function execute($method, $url, $fields = '', $userAgent = '', $httpHeaders = '', $username = '', $password = '')
    {
        //创建curl资源
        $curl_resource = $this->create();

        //判断curl资源
        if (false === $curl_resource) {
            return false;
        }

        if (is_string($url) && strlen($url)) {
            //设置url
            curl_setopt($curl_resource, CURLOPT_URL, $url);
        } else {
            return false;
        }

        //是否显示头部信息
        curl_setopt($curl_resource, CURLOPT_HEADER, false);

        //以字符串形式返回传输
        curl_setopt($curl_resource, CURLOPT_RETURNTRANSFER, true);

        if ($username != '') {
            curl_setopt($curl_resource, CURLOPT_USERPWD, $username . ':' . $password);
        }

        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($curl_resource, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_resource, CURLOPT_SSL_VERIFYHOST, FALSE);
        }

        $method = strtolower($method);

        if ('post' == $method) {
            curl_setopt($curl_resource, CURLOPT_POST, true);
            if (is_array($fields)) {
                $sets = array();
                foreach ($fields AS $key => $val) {
                    $sets[] = $key . '=' . urlencode($val);
                }
                $fields = implode('&', $sets);
            }
            curl_setopt($curl_resource, CURLOPT_POSTFIELDS, $fields);
        } else if ('put' == $method) {
            curl_setopt($curl_resource, CURLOPT_PUT, true);
        }

        //curl_setopt($curl_resource, CURLOPT_PROGRESS, true);
        //curl_setopt($curl_resource, CURLOPT_VERBOSE, true);
        //curl_setopt($curl_resource, CURLOPT_MUTE, false);

        //设置curl超时秒数
        curl_setopt($curl_resource, CURLOPT_TIMEOUT, 10);

        //设置User-Agent信息
        if (strlen($userAgent)) {
            curl_setopt($curl_resource, CURLOPT_USERAGENT, $userAgent);
        }

        //设置Http头
        if (is_array($httpHeaders)) {
            curl_setopt($curl_resource, CURLOPT_HTTPHEADER, $httpHeaders);
        }

        $return = curl_exec($curl_resource);

        if (curl_errno($curl_resource)) {
            curl_close($curl_resource);
            return array(curl_error($curl_resource), curl_errno($curl_resource));
        } else {
            curl_close($curl_resource);
            if (!is_string($return) || !strlen($return)) {
                return false;
            }
            return $return;
        }
    }

    /**
     * curl支持 检测
     *
     * @access private
     *
     * @return bool|null|resource
     */
    private function create()
    {
        $curl_resource = null;

        if (!function_exists('curl_init')) {
            return false;
        }

        $curl_resource = curl_init();

        if (!is_resource($curl_resource)) {
            return false;
        }

        return $curl_resource;
    }
}