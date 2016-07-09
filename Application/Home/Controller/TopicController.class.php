<?php
/**
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
namespace Home\Controller;
use Home\Controller\BaseController;

// use Home\Model\FactoryModel;
/**
 * 主题控制器
 */
class TopicController extends BaseController {

    public $Topic;

    function __construct() {
        parent::__construct();
        if (!checkLogin()) {
            $this->redirect("User/login", array('alert' => '1'), 0);
        }
        $this->Topic = D('Topic');
    }

    public function index() {
        $this->redirect("Index/index", 0);
    }

    /**
     * 发布新主题
     */
    public function add($nid = "") {
        if (IS_POST) {
            $data['title'] = I('post.title', '', 'trim');
            $data['content'] = I('post.content', '', 'trim');
            $data['node_id'] = I('post.node_id', '', 'intval');
            $data['cat_id'] = D('Node')->getCatIdByNodeId($data['node_id']);
            $data['uid'] = session('uid');
            if ($this->Topic->addTopic($data)) {
                $this->success('发布主题成功', U("Index/index"));
            } else {
                $this->error('发布新主题失败,请稍后重试');
            }
        } else {
            $Node = D('Node');
            $nodes = $Node->getAllNodes();
            $hotNodes = $Node->getHotNodes();
            $this->assign('nid', $nid);
            $this->assign('nodes', $nodes);
            $this->assign('hotNodes', $hotNodes);
            $this->display('new');
        }
    }

    /**
     * 主题详情
     * @return [type] [description]
     */
    public function detail() {
        $tid = I('get.tid', '', 'intval');
        if (!$this->Topic->checkTid($tid)) {
            $this->error('传输参数错误');
        }
        $topicInfo = $this->Topic->getDataById($tid);        //根据tid获取详情
        $commentInfo = D('Comment')->getCommentByTid($tid);    //根据tid获取评论
        $this->assign('topicInfo', $topicInfo);
        $this->assign('commentInfo', $commentInfo);
        $this->assign('tid', $tid);
        $this->showSidebar('all');//展示侧边栏
        $this->display();
    }

    /**
     * 追加主题内容
     * @return [type] [description]
     */
    public function append() {
        if (IS_POST) {
            $content = I('post.content', '', 'trim') == '' ?
                $this->error('追加信息不能为空') :
                I('post.content', '', 'trim');
            $tid = I('post.tid', '', 'intval');
            if (!$this->Topic->checkTid($tid)) {
                $this->error('不要修改tid值');
            }
            if (!$this->Topic->appendContent($tid, $content)) {
                $this->error($this->Topic->getError());
            }
            $this->success('追加信息成功!', U('Topic/detail', array('tid' => I('get.tid'))));
        } else {
            $data['tid'] = I('get.tid', '', 'intval');
            $data['title'] = $this->Topic->getFieldByTid($data['tid'], 'title');
            $data['node'] = D('node')->getNodeByTid($data['tid']);
            $this->assign('data', $data);
            $this->display();
        }
    }

    /**
     * 收藏主题
     */
    public function collect_topic() {
        if (!IS_AJAX) {
            $this->error('非法访问');
        } else {
            $tid = I('post.tid');
            if ($tid) {
                if ($this->Topic->collectTopic($tid)) {
                    //成功
                    $this->ajaxReturn('1');
                } else {
                    //失败
                    $this->ajaxReturn('0');
                }
            } else {
                $this->ajaxReturn('0');
            }
        }
    }

    /**
     * 取消收藏主题
     */
    public function remove_col_topic() {
        if (!IS_AJAX) {
            $this->error('非法访问');
        } else {
            $tid = I('post.tid');
            if ($tid) {
                if ($this->Topic->removeColTopic($tid)) {
                    //成功
                    $this->ajaxReturn('1');
                } else {
                    //失败
                    $this->ajaxReturn('0');
                }
            } else {
                //失败 没有接受到tid值
                $this->ajaxReturn('0');
            }
        }

    }
}