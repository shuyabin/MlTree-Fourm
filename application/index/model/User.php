<?php
namespace app\index\model;

use think\Model;
use think\Db;


class User extends Model 
{
    public $userInfo;
    public $groupData;

    protected $pk = 'uid';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_date';
    protected $updateTime = 'login_date';
    protected $auto = ['login_ip'];
    protected $insert = ['create_ip'];

    protected function setCreateIpAttr()
    {
        return \request()->ip();
    }
    protected function setLoginIpAttr()
    {
        return \request()->ip();
    }
    protected function setPasswordAttr($val,$data)
    {
        if(!empty(session('uid')) && !empty(session('salt')))//用户已经登录
        {
            $userData = Db::name('user')->where('uid',session('uid'))->find();
            return md5($val.$userData['salt'].$userData['email']);
        }
        return md5($data['password'].$data['salt'].$data['email']);
    }
    

    static function checkCaptcha($code)
    {
		if(!captcha_check($code)){
		 	return false;
		}
		return true;
    }
    
}

