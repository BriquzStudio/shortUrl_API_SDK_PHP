<?php
/**
 * 0x3.me 单文件版SDK
 */

namespace ShortURL;

class API {

    /**
     * 接口请求成功标示
     */
    const REQUEST_SUCCESS = 1;

    /**
     * 接口请求失败标示
     */
    const REQUEST_FAILURE = 0;

    /**
     * API服务器地址
     */
    const API_SERVER = 'https://0x3.me/';

    /**
     * 接口请求的api_key,可在后台查询到
     * @see https://0x3.me/uc/api
     * @var string
     */
    private $api_key;

    /**
     * 接口请求的密钥,可在后台查询到
     * @see https://0x3.me/uc/api
     * @var string
     */
    private $secret_key;

    private $request_array;

    public function __construct($api_key = '', $secret_key = '') {
        if (!empty($api_key)) {
            $this->api_key = $api_key;
        }
        if (!empty($secret_key)) {
            $this->secret_key = $secret_key;
        }
    }

    public function setApiKey($api_key) {
        $this->api_key = $api_key;
    }

    public function setSecretKey($secret_key) {
        $this->secret_key = $secret_key;
    }

    public function importConfig($config) {
        if (!isset($config['api_key']) || !isset($config['secret_key'])) {
            throw new Exception('illegal config');
        }
        $this->api_key = $config['api_key'];
        $this->secret_key = $config['secret_key'];
    }

    /**
     * API接口之api/add封装
     * @param string $longurl
     * @param string $redirect_method
     * @param string $extra
     * @param string $domain
     * @param string $backfix
     * @param string $password
     * @param int $visitlimit
     * @return array
     * @throws Exception
     */
    public function add($longurl, $redirect_method = '302', $extra = 'N/A', $domain = '0x3', $backfix = '', $password = '', $visitlimit = 0) {
        $params = get_defined_vars();
        return $this->postRequest('api/add', $params);
    }

    public function statics($shorturl) {
        $params = get_defined_vars();
        return $this->postRequest('api/statics', $params);
    }

    public function addtarget($targetname, $shorturl, $longurl, $device = null, $app = null, $region = null) {
        $params = get_defined_vars();
        if ($device == null) unset($params['device']);
        if ($app == null) unset($params['app']);
        if ($region == null) unset($params['region']);
        return $this->postRequest('api/addtarget', $params);
    }

    public function modify($shorturl,$newurl){
        $params = get_defined_vars();
        return $this->postRequest('api/modify', $params);
    }

    public function delete($shorturl){
        $params = get_defined_vars();
        return $this->postRequest('api/delete', $params);
    }

    public function export($shorturl,$time_stamp = 0){
        $params = get_defined_vars();
        return $this->postRequest('api/export', $params);
    }

    public function balance(){
        $params = get_defined_vars();
        return $this->postRequest('api/balance', $params);
    }

    /**
     * 请求api
     * @param $api_name string API名称
     * @param $params array API参数
     * @throws Exception
     * @return array
     */
    private function postRequest($api_name, $params) {
        if (empty($this->api_key) || empty($this->secret_key)) {
            throw new Exception('no config found');
        }
        $params['apikey'] = $this->api_key;
        $params['sign'] = $this->generateSign($params);
        $api_url = self::API_SERVER . $api_name;
        $ch = curl_init();
        $options = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $api_url,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $ret = curl_errno($ch);
        if ($ret !== 0) {
            curl_close($ch);
            throw new Exception('curl network failed');
        } else {
            return json_decode($response, true);
        }
    }

    private function generateSign($params) {
        ksort($params);
        $sig = '';
        foreach ($params as $key => $value) {
            $sig .= sprintf('%s=%s', $key, $value);
        }
        $sig .= $this->secret_key;
        return md5($sig);
    }


}

class Exception extends \Exception {

}
