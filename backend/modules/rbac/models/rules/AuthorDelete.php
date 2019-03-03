<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/24
 * Time: 16:46
 */
namespace rbac\models\rules;
use Yii;
use yii\rbac\Rule;

class AuthorDelete extends Rule
{
    public $name = 'deleteIsAuthor';
    /**
     * @param string|integer $user 用户 ID.
     * @param Item $item 该规则相关的角色或者权限
     * @param array $params 传给 ManagerInterface::checkAccess() 的参数
     * @return boolean 代表该规则相关的角色或者权限是否被允许
     */
    public function execute($user, $item, $params)
    {
        // 判断post的createdby是否为当前用户($user为当前用户ID)
        return isset($params['post']) ? $params['post']->createdBy == $user : false;
    }

}
