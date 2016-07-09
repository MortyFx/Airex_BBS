<?php
/**
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
namespace Home\Model;
use Think\Model;

class CommentModel extends Model {

    /**
     * 根据tid获取相应评论
     * @param  [type] $tid [description]
     * @return [type]      [description]
     */
    public function getCommentByTid($tid) {
        $commentInfo = $this
            ->where(array('tid' => $tid))
            ->field('user_name,content,publish_time,imgpath,airex_comment.id as cid,u.id as cuid')
            ->join('airex_user as u on u.id = airex_comment.uid')
            ->order('publish_time asc')//按照回复时间正序排列
            ->select();
        return $commentInfo;
    }

    /* 根据用户名获取评论
    * @param  string $username [description]
    * @return [type]           [description]
    */
    public function getCommentByUser($username, $limit = '') {
        $comments['lists'] = M('user as u')->where(array('u.user_name' => $username))
            ->join('airex_comment as c on c.uid = u.id')
            ->join('airex_topic as t on t.id = c.tid')
            ->join('airex_user as u1 on u1.id = t.uid')
            ->field('tid,c.publish_time as publish_time,c.content as content,t.title as title,u1.user_name as user_name')
            ->order('c.publish_time desc')
            ->limit('0,' . $limit)
            ->select();
        return $comments;
    }

}