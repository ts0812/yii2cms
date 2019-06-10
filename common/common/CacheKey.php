<?php
/**
 */

namespace common\common;
use yii;
/**
 * StringHelper
 *
 * @SuppressWarnings(PHPMD)
 */
class CacheKey
{
    /**
     * token缓存校验
     * @param string $token
     * @return string
     */
    public static function tokenUserId(string $token): string
    {
        return 'tokenUserId'.$token;
    }
    /**
     * 设置用户token名称
     * @param string $token
     * @return string
     */
    public static function setTokenName(string $userId): string
    {
        return  md5(base64_encode($userId . md5(date('Y-m-d H:i:s')) .md5(SECRET_SALT)));
    }
    /**
     * 设置用户token
     * @param string $token
     * @return string
     */
    public static function setToken(string $userId,$data)
    {
        $token =  md5(base64_encode($userId . md5(date('Y-m-d H:i:s')) .md5(SECRET_SALT)));
        $cacheToken = self::tokenUserId($token);
        $data['token']=$token;
        $res = yii::$app->cache->set($cacheToken,$data,TOKEN_OUT_TIME);
        if($res)
            return $token;
        return false;

    }
    /**
     * 删除用户token身份
     * @param string $token
     * @return string
     */
    public static function delToken(string $token){
	$cacheToken = self::tokenUserId($token);
	$res = yii::$app->cache->delete($cacheToken);
	return $res;
    }
    /**
     * 手机验证码
     * @param string $phone
     * @return string
     */
    public static function phoneVerify(string $phone)
    {
        return 'phoneVerify'.$phone;
    }

    /**
     * 一天验证短信次数
     * @param string $phone
     * @return string
     */
    public static function phoneVerifyNum(string $phone)
    {
        return 'phoneVerifyNum'.date('Ymd').$phone;
    }


}
