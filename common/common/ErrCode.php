<?php
namespace common\common;

use Yii;
class ErrCode
{
    ///获取标注key
    public static function code(int $code = 1)
    {
        $errCode = [
            0 => [ 'status' => 0 ],
            1 => [ 'status' => 1 , 'message' => 'ok', 'data' => null],
            1000 => [ 'status' => 1000 , 'message' => Yii::t('app' , '用户未登录')], //用户未登录
            1001 => [ 'status' => 1001 , 'message' => Yii::t('app' , '账号密码错误')], //账号或者密码错误
            1002 => [ 'status' => 1002 , 'message' => Yii::t('app' , '身份过期')],  //Token过期
            1003 => [ 'status' => 1003 , 'message' => Yii::t('app' , '账号已被停用，请联系管理员')],  //用户已被停用
            1004 => [ 'status' => 1004 , 'message' => Yii::t('app' , '用户名不存在')], //用户不存在
            1005 => [ 'status' => 1005 , 'message' => Yii::t('app' , 'This user cannot operate this data')],
            1006 => [ 'status' => 1006 , 'message' => Yii::t('app' , '操作失败')],
            1007 => [ 'status' => 1007 , 'message' => Yii::t('app' , '未登录或身份过期,请重新登录')],  //Token不存在
            1008 => [ 'status' => 1008 , 'message' => Yii::t('app' , '数据不存在')],
            1009 => [ 'status' => 1009 , 'message' => Yii::t('app' , '参数错误')], //参数错误
            1010 => [ 'status' => 1010 , 'message' => Yii::t('app' , 'This user has no device')],
            1011 => [ 'status' => 1011 , 'message' => Yii::t('app' , '账号在其他地方登录')],
            1012 => [ 'status' => 1012 , 'message' => Yii::t('app' , 'This account has no configuration information.')],
            1013 => [ 'status' => 1013 , 'message' => Yii::t('app' , 'Code is incorrect')],
            1014 => [ 'status' => 1014 , 'message' => Yii::t('app' , 'Route data does not exist')],
            1015 => [ 'status' => 1015 , 'message' => Yii::t('app' , 'Ground station does not exist')],
            1016 => [ 'status' => 1016 , 'message' => Yii::t('app' , '无权限访问')],
            1017 => [ 'status' => 1017 , 'message' => Yii::t('app' , '设备不存在')],
            1018 => [ 'status' => 1018 , 'message' => Yii::t('app' , '文件上传失败')],
            1019 => [ 'status' => 1019 , 'message' => Yii::t('app' , '文件下载失败')],
            9999 => [ 'status' => 9999 , 'message' => Yii::t('app' , '接口错误')],
        ];
        return $errCode[$code];
    }

    public static function dieCode(int $code, $data = null)
    {
        $arrCode = self::code($code);
        if($data){
            $arrCode['data'] = $data;
        }
        Yii::$app->end(json_encode($arrCode));
    }
    /**
     * 接口返回信息
     * @param int $code
     * @param array|string $data
     * @return mixed
     */
    public static function errCode($code = 1 , $data = null)
    {
        $errCode = self::code($code);
        $errCode['data'] = $data;
        header("errCode: $code");
        header("content:application/json;chartset=uft-8");
        if($code === 0){
            $errCode['data'] = null;
            $errCode['message'] = self::getErrorsMessage($data);
        }
        die(json_encode($errCode,JSON_UNESCAPED_UNICODE ));
    }

    /**
     * 获取yii 验证错误 的msg
     * @param $errors
     */
    static protected function getErrorsMessage($errors)
    {
        if(is_array($errors) && $errors){
            $firstError = array_shift($errors);
            return array_shift($firstError);
        }
        return $errors;
    }
}
