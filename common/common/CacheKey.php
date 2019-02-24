<?php
/**
 */

namespace common\common;
/**
 * StringHelper
 *
 * @SuppressWarnings(PHPMD)
 */
class CacheKey
{

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
