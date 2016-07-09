<?php
/**
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
namespace Home\Model;

use Think\Model;

/**
 * 用户模型类.
 */
class UserModel extends Model {


    //自动验证注册表单
    protected $_validate = array(
        array('user_name', 'require', '用户名不能为空', 1),
        array('user_name', '/^\w+$/', '用户名不合法(只能包含英文、数字、下划线)', 1),
        array('user_name', '', '用户名已被占用', 1, 'unique'),
        array('password', 'require', '密码不能为空', 1),
        array('email', 'require', 'Email不能为空', 1),
        array('email', '', 'Email已被占用', 1, 'unique'),
        array('email', 'email', 'Email格式不正确', 1),
    );

    /**
     * AJAX检查占用用户名
     * @param  string $username [description]
     * @return json
     */
    public function checkUsername($username) {

        $data = $this->where("user_name='$username'")->find();
        if ($data) {
            $msg = array('occupied' => 1);
            return json_encode($msg);
        } else {
            $msg = array('occupied' => 0);
            return json_encode($msg);
        }

    }


    /**
     * AJAX检查占用Email
     * @param  string $email [description]
     * @return json
     */
    public function checkEmail($email) {

        $data = $this->where("email='$email'")->find();
        if ($data) {
            $msg = array('occupied' => 1);
            return json_encode($msg);
        } else {
            $msg = array('occupied' => 0);
            return json_encode($msg);
        }

    }


    /**
     * 新增用户
     * @param  array $userinfo [description]
     * @return boolean
     */
    public function userRegister($userinfo) {
        $userinfo['password'] = $this->passwordHasher($userinfo['password']); //用户密码加密
        if ($this->create($userinfo)) {
            if ($this->add()) {
                //session('user',$userinfo['user_name']); //session 注册后进入已登录状态
//                $siteInfo = M('siteinfo');
//                $siteInfo->setField($data);
                $siteInfo = M('siteinfo');
                $siteInfo->where('id=1')->setInc('member_num', 1); //站点信息用户数加1
                return true;
            }
        }
    }

    /**
     * 用户登录
     * @param  array $userinfo [description]
     * @return int           0没有此用户 返回1登录成功 返回2密码错误
     */
    public function userLogin($userinfo) {
        $username = $userinfo['user_name'];
        $password = $this->passwordHasher($userinfo['password']); //将密码加密 与数据库比对
        //$data = $this->where('user_name = "'.$username.'"')->find();
        $user_id = $this->where('user_name = "' . $username . '"')->getField('id');
        $data = $this->where('user_name = "' . $username . '"')->getField('id,user_name,password'); //返回二维数组以ID为索引
        if ($data) {
            if ($password == $data[$user_id]['password']) {
                session('user', $data[$user_id]['user_name']); // 将已登录用户名加入SESSION
                session('uid', $data[$user_id]['id']); // 将用户ID加入SESSION
                return 1; //登录成功
            } else {
                return 2; //密码错误
            }
        } else {
            return 0; //不存在此用户
        }
    }

    /**
     * 更新用户登录IP
     * @param  string $username [description]
     * @return
     */
    public function updateLoginIP($username) {

        $this->where('user_name = "' . $username . '"')->setField('login_ip', ip2long(get_real_ip()));
    }

    /**
     * 用户加密函数
     * @param  string $password [description]
     * @return string [返回加密后的密码]
     */
    public function passwordHasher($password) {
        //加密思路：原始密码->MD5(32)->sha1(40)->截取前32位
        return substr(sha1(md5($password)), 0, 32);
    }

    /**
     * 忘记密码-通过邮件查询用户名
     * @param  string $email [description]
     * @return string $username[返回用户名]
     */
    public function getUsernameByEmail($email) {

        $username = $this->where('email = "' . $email . '"')->getField('user_name');
        return $username;
    }

    /**
     * 发送重置密码用剑
     * @param  string $username [description]
     * @param  string $emaill [description]
     * @return boolean
     */
    public function sendResetpwEmail($email, $username) {

        $hash = $this->passwordHasher($email . time()); //用加密函数生成hash
        $date = date('Y-n-j', time());
        $url = 'http://' . I('server.HTTP_HOST') . U('User/resetpw') . '?hash=' . $hash;
        $content = '你好，<br><br>请点击以下链接来重设你的密码：<br><br><a href="' . $url . '" target="_blank">' . $url . '</a><br><br><b>请不要将此链接告诉其他人，请在60分钟内完成密码重置！</b><br><br>Airex社区 ' . $date;
        if (SendMail($email, '[Airex] ' . $username . '，请重置你的密码！', $content)) {
            $db_resetpw = M('resetpw');
            $db_resetpw->where('expire <= ' . (time() - 3600))->delete(); //清空过期密钥
            $data['hash'] = $hash;
            $data['expire'] = time() + 3600; //密钥过期时间：1小时
            $data['user_name'] = $username;
            $db_resetpw->add($data);
            //session(array('name'=>'PHPSESSID','expire'=>600));//session失效时间为60分钟
            //session($hash,$username); //将hash加入session
            return true;
        } else {
            return false;
        }

    }

    /**
     * 获取重置密码的hash是否有效
     * @param  string $hash [description]
     * @return boolean or string
     */
    public function checkResetpwHash($hash) {
        $db_resetpw = M('resetpw');
        if ($data = $db_resetpw->where('hash = "' . $hash . '"')->find()) { //判断是否存在密钥
            if ($data['expire'] >= time()) { //判断密钥是否过期
                return $data['user_name'];
            } else {
                $this->deleteResetpwHash($hash);//若过期则删除此密钥
                //$db_resetpw->where('hash = "'.$hash.'"')->delete();
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * 删除重置密码hash
     * @param  string $hash [description]
     * @return
     */
    public function deleteResetpwHash($hash) {
        $db_resetpw = M('resetpw');
        $db_resetpw->where('hash = "' . $hash . '"')->delete();
    }

    /**
     * 更新用户密码
     * @param  string $username [description]
     * @param  string $password [description]
     * @return
     */
    public function updatePassword($username, $password) {

        $this->where('user_name = "' . $username . '"')->save(array('password' => $this->passwordHasher($password)));
    }

    /**
     * 用户信息页 获取用户信息
     * @return array 获取的用户数据
     */
    public function getUserInfo($member) {
        $username = $member;
        $data = $this->where(array('user_name' => $username))
            ->field('id,url,resume,user_name,imgpath,gender,create_time')
            ->select()[0];
        if ($data) {
            $attention = M('attention');
            if (I('session.uid')) {
                if ($attention->where('uid=' . I('session.uid') . ' AND atten_uid=' . $data['id'])->find()) {
                    $data['attention'] = 1;
                } else {
                    $data['attention'] = 0;
                }
            }
            return $data;
        }

    }

    /**
     * 添加用户特别关注
     * @param int targetUserID [要关注的用户ID]
     * @return array 获取的用户数据
     */
    public function addAttention($targetUserID) {
        $userID = I('session.uid');
        $attention = M('attention');
        $data['uid'] = $userID;
        $data['atten_uid'] = $targetUserID;
        if ($attention->data($data)->add()) {
            $this->where('id=' . $userID)->setInc('attentions', 1);
            return true;
        }
    }

    /**
     * 取消用户特别关注
     * @param int targetUserID [要关注的用户ID]
     * @return array 获取的用户数据
     */
    public function removeAttention($targetUserID) {
        $userID = I('session.uid');
        $attention = M('attention');
        $data['uid'] = $userID;
        $data['atten_uid'] = $targetUserID;
        if ($attention->where('uid=' . $userID . ' AND atten_uid=' . $targetUserID)->delete()) {
            $this->where('id=' . $userID)->setDec('attentions', 1);
            return true;
        }
    }

    /**
     * 获取用户的特别关注
     * @param
     * @return array [特别关注的用户UID数组]
     */
    public function getUserAttentions() {
        $uid = I('session.uid');
        $attention = M('attention');
        $attentions = $attention->where('uid=' . $uid)->getField('atten_uid', TRUE);
        return $attentions;
    }

    /**
     * 侧边栏 获取用户信息
     * @return array 获取的用户数据
     */
    public function getSidebarUserInfo() {
        $uid = session('uid');
        $data = $this->where(array('id' => $uid))
            ->field('imgpath,attentions,topics,wealth,nodes')
            ->select()[0];
        $data['notifications'] = M('reply')->where(array('to_uid' => $uid, 'is_read' => '否'))
            ->count();
        return $data;
    }

    /**
     * 用户设置页 获取用户信息
     * @return array 获取的用户数据
     */
    public function getSettingUserInfo() {
        $uid = session('uid');
        $data['userInfo'] = $this->where(array('id' => $uid))
            ->field('url,resume,email,gender,imgpath,attentions,topics,wealth,nodes')
            ->select()[0];
        $data['notifications'] = M('reply')->where(array('to_uid' => $uid, 'is_read' => '否'))
            ->count();
        return $data;
    }

    /**
     * 用户设置页 更新用户信息
     * @return boolean
     */
    public function updateUserInfo($data) {
        $rules = array(
            array('gender', 'checkGender', '性别不合法', 1, 'callback'),
            array('url', 'url', 'url不合法', 2),
            array('resume', '0,50', '个人简介长度50字以内', 2, 'length'),
        );
        $uid = I('session.uid');
        if ($this->validate($rules)->create()) {
            $this->where('id = ' . $uid)->save($data);
            return true;
        }
    }

    /**
     * 检查性别是否合法
     * @return boolean
     */
    public function checkGender($gender) {
        $gender_arr = array('男', '女', '保密');
        if (in_array($gender, $gender_arr)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 上传头像
     * @param  file $avatar [description]
     * @return boolean
     */
    public function uploadAvatar($avatar) {

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置允许上传大小 默认3M
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置上传类型
        $upload->rootPath = './Public/Home/img/avatar/'; // 设置上传根目录
        $upload->autoSub = false;
        $upload->saveName = I('session.uid'); //以用户ID保存头像文件名
        $upload->replace = true;
        // 上传单个文件
        $info = $upload->uploadOne($avatar);
        if (!$info) {
            return $upload->getError();
        } else {
            $avatarPath = './Public/Home/img/avatar/' . $info['savename'];
            $image = new \Think\Image();  //实例化图片操作类 裁剪头像为48*48
            $image->open($avatarPath);
            $image->thumb(48, 48, $image::IMAGE_THUMB_FIXED)->save($avatarPath);
            $this->where('id=' . I('session.uid'))->setField('imgpath', '/home/img/avatar/' . $info['savename']); //数据库更新头像字段
            return true;
        }

    }

}