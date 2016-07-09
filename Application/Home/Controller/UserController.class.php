<?php
/**
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
namespace Home\Controller;

use Home\Controller\BaseController;

/**
 * 用户控制器.
 */
class UserController extends BaseController {

    private $User;
    private $Cate;
    private $Node;
    private $Topic;
    private $Comment;

    function __construct() {
        parent::__construct();
        $this->User = D('User');
        $this->Cate = D('Category');
        $this->Node = D('Node');
        $this->Topic = D('Topic');
        $this->Comment = D('Comment');
    }

    /**
     * 验证码生成
     */
    public function captcha() {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 30;
        $Verify->length = 4;
        $Verify->useNoise = false;
        $Verify->entry();
    }

    /**
     * 用户登录
     */
    public function login() {
        if (checkLogin()) {
            $this->redirect("Index/index", '', 0);
        }
        if (IS_POST) {
            //$User = new \Home\Model\UserModel();
            $postinfo = array("user_name" => I('post.username'), "password" => I('post.password'));
            switch ($this->User->userLogin($postinfo)) {
                case 0: //无此用户
                    $this->error('没有此用户！');
                    break;
                case 1: //登录成功
                    $this->User->updateLoginIP($postinfo['user_name']); //更新用户登录IP
                    $this->success('登录成功，正在转向首页...', U('Index/index'), 1);
                    break;
                case 2: //密码不对
                    $this->error('用户名或密码不正确！');
                    break;
            }
        } else {
            switch (I('get.alert')) {
                case 1:
                    $this->assign('alert_content', '您还未登录，请登录后再查看或创建主题；若您还未注册请<a href="' . U('User/register') . '">点此注册</a>');
                    break;
                case 2:
                    $this->assign('alert_content', '您已注册成功，请输入您注册时填写的用户名与密码进行登录');
                    break;
            }
            $this->display();
        }
    }


    /**
     * 用户注册
     */
    public function register() {
        if (checkLogin()) {
            $this->redirect("Index/index", '', 0);
        }
        //$User = new \Home\Model\UserModel();
        if (IS_POST) {
            if (check_verify(I('post.captcha'))) {

                $postinfo = array("user_name" => I('post.username'), "password" => I('post.password'), "email" => I('post.email'));
                //自动验证
                if ($this->User->userRegister($postinfo)) {
                    $this->success('注册成功！', 'login/alert/2'); //注册成功转向登录页
                } else {
                    $this->error($this->User->getError());
                }
            } else {
                $this->error('验证码错误，请重新输入！');
            }
        } else {
            $this->display();
        }
    }

    /**
     * AJAX检查占用用户名接口
     */
    public function checkUsername() {
        //$User = new \Home\Model\UserModel();
        $username = I('post.username');
        echo $this->User->checkUsername($username);
    }

    /**
     * AJAX检查占用Email接口
     */
    public function checkEmail() {
        //$User = new \Home\Model\UserModel(
        $email = I('post.email');
        echo $this->User->checkEmail($email);
    }

    /**
     * 忘记密码
     */
    public function forgot() {
        if (checkLogin()) {
            $this->redirect("Index/index", '', 0);
        }
        if (IS_POST) {
            //$User = new \Home\Model\UserModel();
            $email = I('post.email'); //得到参数email
            if ($username = $this->User->getUsernameByEmail($email)) { //此email是否存在数据库中
                if ($this->User->sendResetpwEmail($email, $username)) {  //发送邮件给此email
                    $this->success('重置密码邮件发送成功！', U('Index/index'));
                } else {
                    $this->error('邮件发送失败');
                }
            } else {
                $this->error('不存在此邮箱');
            }
        } else {
            $this->display();
        }
    }

    /**
     * 重置密码
     */
    public function resetpw() {
        if (checkLogin()) {
            $this->redirect("Index/index", '', 0);
        }
        if (I('get.hash')) {  //如果存在hash参数
            $hash = I('get.hash');
            //$User = new \Home\Model\UserModel();
            if ($username = $this->User->checkResetpwHash($hash)) {
                $this->assign('username', $username); //将用户名输出到前端
                if (IS_POST) {
                    if ((I('post.password')) != (I('post.password_r'))) {
                        $this->error('两次密码不一致');
                    } elseif ((I('post.password')) == "" || (I('post.password') == "")) {
                        $this->error('密码不能为空');
                    } elseif (strlen(I('post.password')) < 6) {
                        $this->error('密码长度不得小于6位');
                    } else {
                        $this->User->updatePassword($username, I('post.password'));//更新密码
                        $this->User->deleteResetpwHash($hash); //删除此重置hash
                        $this->success('密码已经重置成功！', 'login'); //密码重置成功转向登录页
                    }
                } else {
                    $this->display();
                }
            } else {
                $this->error('不存在此重置密钥或已失效', U('Index/index'));
            }
        } else {
            $this->error('非法操作', U('Index/index'));
        }
    }

    /**
     * 用户信息设置
     */
    public function setting() {
        if (!checkLogin()) {
            $this->redirect("Index/index", '', 0);
        }

        if (I('post.gender')) {
            if (I('post.url') != "") {
                if (!preg_match("/^(http|ftp):/", I('post.url'))) {
                    $_POST['url'] = 'http://' . I('post.url');
                }   //检测是否有http头，若无则加上
            }
            $data = array("id" => I('session.uid'),
                "gender" => I('post.gender'),
                "url" => I('post.url'),
                "resume" => I('post.resume'));
            //$User = new \Home\Model\UserModel();
            if ($this->User->updateUserInfo($data)) {
                $this->success('用户信息更新成功！');
            } else {
                $this->error($this->User->getError());
            }
        } elseif (I('post.password')) {
            if ((I('post.password')) != (I('post.password_r'))) {
                $this->error('两次密码不一致');
            } elseif ((I('post.password')) == "" || (I('post.password') == "")) {
                $this->error('密码不能为空');
            } elseif (strlen(I('post.password')) < 6) {
                $this->error('密码长度不得小于6位');
            } else {
                $username = I('session.user');
                //$User = new \Home\Model\UserModel();
                $this->User->updatePassword($username, I('post.password'));//更新密码
                $this->success('密码已经重置成功！'); //密码重置成功转向登录页
            }
        } else {
            //$User = new \Home\Model\UserModel();
            $data = $this->User->getSettingUserInfo();
            $this->assign('data', $data);
            $this->showSidebar('all');//展示侧边栏
            $this->display();
        }


    }

    /**
     * 用户头像修改页
     */
    public function avatar() {
        if (!checkLogin()) {
            $this->redirect("Index/index", '', 0);
        }
        if (IS_POST) {
            $msg = $this->User->uploadAvatar($_FILES['avatar']);
            if ($msg === true) {
                $this->success('头像已成功更换！');
            } else {
                $this->error($msg);
            }
        } else {
            $data = $this->User->getSettingUserInfo();
            $this->assign('data', $data);
            $this->showSidebar('all');//展示侧边栏
            $this->display();
        }
    }

    /**
     * 用户登出
     */
    public function logout() {
        session('user', null);
        session('uid', null);
        $this->redirect("User/login", '', 0);
    }

    /**
     * 用户信息页
     */
    public function info($member = null) {
        //$User = new \Home\Model\UserModel();
        if ($member == null) {
            $member = session('user');
        }
        $data = $this->User->getUserInfo($member);
        if ($data) {
            $topics = $this->Topic->getTopicsByUser($member, 5);//根据用户名获取文章
            $comments = $this->Comment->getCommentByUser($member, 10); //获取10条最新评论
            $this->assign('topics', $topics);
            $this->assign('comments', $comments);
            $this->assign('data', $data);
            $this->showSidebar();//展示侧边栏
            $this->display();
        } else {
            $this->error('用户不存在');
        }
    }

    /**
     * 用户特别关注列表页
     */
    public function attentions() {
        if (!checkLogin()) {
            $this->redirect("Index/index", '', 0);
        }

        $data = $this->User->getUserInfo(I('session.user'));
        $this->assign('data', $data);
        $attentions = $this->User->getUserAttentions();
        $topics = $this->Topic->getTopicsbyUserID($attentions);
        $this->assign('topics', $topics);
        $this->showSidebar();//展示侧边栏
        $this->display();
    }

    /**
     * AJAX用户加入特别关注
     */
    public function add_attention() {
        if (!checkLogin()) {
            $data['status'] = 0; //返回失败的JSON 原因：未登录
            $this->ajaxReturn($data);
        }
        if (!IS_POST) {
            $this->error('非法访问');
        } else {
            $targetUserID = I('post.userID');
            if ($targetUserID) {
                if ($this->User->addAttention($targetUserID)) {
                    $data['status'] = 1; //成功
                    $this->ajaxReturn($data);
                } else {
                    $data['status'] = 0; //失败
                    $this->ajaxReturn($data);
                }
            } else {
                $this->error('非法访问');
            }
        }
    }

    /**
     * AJAX用户取消特别关注
     */
    public function remove_attention() {
        if (!checkLogin()) {
            $data['status'] = 0; //返回失败的JSON 原因：未登录
            $this->ajaxReturn($data);
        }
        if (!IS_POST) {
            $this->error('非法访问');
        } else {
            $targetUserID = I('post.userID');
            if ($targetUserID) {
                if ($this->User->removeAttention($targetUserID)) {
                    $data['status'] = 1; //成功
                    $this->ajaxReturn($data);
                } else {
                    $data['status'] = 0; //失败
                    $this->ajaxReturn($data);
                }
            } else {
                $this->error('非法访问');
            }
        }
    }

    /**
     * 用户所有主题列表页
     */
    public function topic($member) {
        //$User = new \Home\Model\UserModel();
        $data = $this->User->getUserInfo($member);
        if ($data) {
            $topics = $this->Topic->getTopicsByUser($member);//根据用户名获取文章
            $this->assign('topics', $topics);
            $this->assign('data', $data);
            $this->showSidebar();//展示侧边栏
            $this->display();
        } else {
            $this->error('此用户不存在！');
        }

    }

    /**
     * 用户所有回复列表页
     */
    public function reply($member) {
        //$User = new \Home\Model\UserModel();
        $data = $this->User->getUserInfo($member);
        if ($data) {
            $this->assign('data', $data);
            $comments = $this->Comment->getCommentByUser($member);
            $this->assign('comments', $comments);
            $this->showSidebar();//展示侧边栏
            $this->display();
        } else {
            $this->error('此用户不存在！');
        }
    }

    /**
     * 用户主题收藏列表页
     */
    public function coltopic() {
        if (!checkLogin()) {
            $this->redirect("Index/index", '', 0);
        }
        $data = $this->User->getUserInfo(I('session.user'));
        $this->assign('data', $data);
        $uid = I('session.uid');
        $coltopic_tid = $this->Topic->getColTopicByID($uid);
        $topics = $this->Topic->getTopicByTID($coltopic_tid);
        $this->assign('topics', $topics);
        $this->showSidebar();//展示侧边栏
        $this->display();
    }
}