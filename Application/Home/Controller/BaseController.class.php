<?php
/**
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
namespace Home\Controller;

use Think\Controller;

/**
 * 基础控制器
 */
class BaseController extends Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * @param $mode [侧边栏模式：默认:单用户信息栏模式/all:加载全部侧边栏模式]
     */
    public function showSidebar($mode) {
        $sidebar['userInfo'] = D('User')->getSidebarUserInfo();//用户信息
        if ($mode == 'all') {
            $sidebar['hotNodes'] = D('Node')->getHotNodes();//热门节点
            $sidebar['siteInfo'] = D('Index')->getSiteInfo();//站点信息
        }
        $this->assign('sidebar', $sidebar);
    }

}