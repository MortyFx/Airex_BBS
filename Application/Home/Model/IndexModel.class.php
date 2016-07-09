<?php
/**
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
namespace Home\Model;


class IndexModel {

    /**
     * 获取首页用户信息展示
     * @return array 获取的数据
     */
    public function getUserInfo() {
        $uid = session('uid');
        $User = M("User");
        $data['userInfo'] = $User->where(array('id' => $uid))
            ->field('imgpath,attentions,topics,wealth,nodes')
            ->select()[0];
        $data['notifications'] = M('reply')->where(array('to_uid' => $uid, 'is_read' => '否'))
            ->count();
        return $data;
    }

    /**
     * 获取站点信息
     * @return [type] [description]
     */
    public function getSiteInfo() {
        $siteInfo = M('siteinfo')->field('member_num,topic_num,comment_num')->select();
        return $siteInfo[0];
    }
}