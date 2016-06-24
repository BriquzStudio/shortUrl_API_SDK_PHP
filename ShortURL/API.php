<?php
/**
 * 0x3.me site API PHP SDK 核心API class文件
 *
 * @package   ShortURL
 * @author    zhiping.yin <yzp@bz-inc.com>
 * @copyright 2016 0x3.me
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @version   Release: 1.0
 * @link      https://0x3.me/api
 */

namespace ShortURL;

use ShortURL\Model\addModel;
use ShortURL\Model\addtargetModel;
use ShortURL\Model\balanceModel;
use ShortURL\Model\base;
use ShortURL\Model\deleteModel;
use ShortURL\Model\exportModel;
use ShortURL\Model\modifyModel;
use ShortURL\Model\staticsModel;

final class API {

    /**
     * @var \ShortURL\Config
     */
    private $config;

    public function __construct($config = null) {
        if (!is_null($config) && $config instanceof \ShortURL\Config) {
            $this->config = $config;
        }
    }

    /**
     * API magic method __destruct
     */
    public function __destruct() {

    }

    /**
     * API magic method __clone
     * @throws Exception\Exception
     */
    public function __clone() {
        throw new \ShortURL\Exception\Exception('API magic method __clone not allowed');
    }

    /**
     * API magic method __set
     * @param $name
     * @param $value
     * @throws Exception\Exception
     */
    public function __set($name, $value) {
        throw new \ShortURL\Exception\Exception('API magic method __set not allowed');
    }

    /**
     * API magic method __get
     * @param $name
     * @throws Exception\Exception
     */
    public function __get($name) {
        throw new \ShortURL\Exception\Exception('API magic method __get not allowed');
    }

    /**
     * API magic method __call
     * @param $function_name
     * @param $arguments
     * @return array
     */
    public function __call($function_name,$arguments) {
        return call_user_func(array($this,'requestAPI'),'api/'.$function_name,$arguments);
    }

    /**
     * 获取配置
     * @return null|Config
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * 设置配置
     * @param $config \ShortURL\Config
     */
    public function setConfig($config) {
        $this->config = $config;
    }

    /**
     * 请求API
     * @param $api_name string
     * @param $params_model \ShortURL\Model\base
     * @throws Exception\Config\Exception
     * @return array
     */
    public function requestAPI($api_name, $params_model) {
        if(empty($this->config)){
            throw new \ShortURL\Exception\Config\Exception('config not found');
        }
        $params_model->setApiKey($this->config->getApiKey());
        $params_model->setSecretKey($this->config->getSecretKey());

        $request_result = \ShortURL\Util::post($this->config->getServerAddress().$api_name,$params_model->exportParams());
        $result = json_decode($request_result,true);
        if(!$result){
            throw new \ShortURL\Exception\Exception('api request failed');
        }
        return $result;
    }

    /**
     * api/add接口
     * @param $params addModel|base
     * @return array
     * @throws Exception\Config\Exception
     * @throws Exception\Exception
     */
    public function add($params) {
        return $this->requestAPI('api/add',$params);
    }

    /**
     * api/statics接口
     * @param $params staticsModel|base
     * @return array
     * @throws Exception\Config\Exception
     * @throws Exception\Exception
     */
    public function statics($params){
        return $this->requestAPI('api/statics',$params);
    }

    /**
     * api/addtarget接口
     * @param $params addtargetModel|base
     * @return array
     * @throws Exception\Config\Exception
     * @throws Exception\Exception
     */
    public function addtarget($params){
        return $this->requestAPI('api/addtarget',$params);
    }

    /**
     * api/modify接口
     * @param $params modifyModel|base
     * @return array
     * @throws Exception\Config\Exception
     * @throws Exception\Exception
     */
    public function modify($params){
        return $this->requestAPI('api/modify',$params);
    }

    /**
     * api/delete接口
     * @param $params deleteModel|base
     * @return array
     * @throws Exception\Config\Exception
     * @throws Exception\Exception
     */
    public function delete($params){
        return $this->requestAPI('api/delete',$params);
    }

    /**
     * api/export接口
     * @param $params exportModel|base
     * @return array
     * @throws Exception\Config\Exception
     * @throws Exception\Exception
     */
    public function export($params){
        return $this->requestAPI('api/export',$params);
    }

    /**
     * api/balance接口
     * @param $params balanceModel|base
     * @return array
     * @throws Exception\Config\Exception
     * @throws Exception\Exception
     */
    public function balance($params){
        return $this->requestAPI('api/balance',$params);
    }
}