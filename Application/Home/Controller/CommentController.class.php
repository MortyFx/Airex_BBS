<?php
/**
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
namespace Home\Controller;
use Home\Controller\BaseController;

/**
 * 评论控制器
 */
class CommentController extends BaseController {
    /**
     * 新增评论(回复)
     * type:0->评论  1->回复
     * data->评论数据  reply_data->回复数据
     */
    public function add() {
        if (IS_AJAX) {
            $data['tid'] = I('post.tid', '', 'intval');
            $Topic = D('Topic');
            if (!$Topic->checkTid($data['tid'])) {
                $this->ajaxReturn('no');
            }
            $data['content'] = I('post.content', '', 'trim');
            if ($data['content'] == '') {
                $this->ajaxReturn('no');
            }
            $data['publish_time'] = date('Y-m-d H:i:s', time());
            $data['uid'] = session('uid');
            switch (I('post.type', '', 'intval')) {
                case 0:                //评论
                    $dta['type'] = '评论';
                    break;
                case 1:                //回复
                    $data['type'] = '回复';
                    $reply_data['to_uid'] = I('post.toUid', '', 'intval');
                    $reply_data['from_uid'] = session('uid');
                    $reply_data['tid'] = $data['tid'];
                    $reply_data['create_time'] = $data['publish_time'];
                    $reply_data['is_read'] = '否';
                    // $this->ajaxReturn(json_encode($reply_data));
                    break;
                default:
                    $this->ajaxReturn('no');
                    break;
            }
            if (M('Comment')->add($data)) {
                $this->trigger($Topic, $data);
                if ($data['type'] == '回复') {
                    $this->notify($reply_data);
                }
                $this->ajaxReturn('yes');
            } else {
                $this->ajaxReturn('no');
            }
        }
    }

    /**
     * 触发更新
     * @param  [type] $tid   [description]
     * @param  [type] $Topic [description]
     * @return [type]        [description]
     */
    public function trigger($Topic, $data) {
        M('siteinfo')->where(['id' => 1])->setInc('comment_num');
        $Topic->where(['id' => $data['tid']])->setInc('comments');
        $Topic->last_comment_user = session('user');
        $Topic->last_comment_time = $data['publish_time'];
        $Topic->where(['id' => $data['tid']])->save();
    }

    /**
     * 回复提醒
     * @param  [type] $data 未读回复信息
     * @return [type]       [description]
     */
    public function notify($reply_data) {
        if (!M('reply')->add($reply_data)) {
            $this->ajaxReturn('no');
        }
    }
}