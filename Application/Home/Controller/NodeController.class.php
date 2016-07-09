<?php
/**
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
namespace Home\Controller;

use Home\Controller\BaseController;

/**
 * 节点控制器
 */
class NodeController extends BaseController {
    public $Node;

    function __construct() {
        parent::__construct();
        $this->Node = D('node');
    }

    /**
     * 获取文章
     * @return [type] [description]
     */
    public function topics() {
        $node = I('get.node');
        if (!nodeValidate($node)) {
            $this->error('传输参数错误');
        }
        $nodeInfo = $this->Node->getNodeInfo($node);
        $topics = D('Topic')->getTopicsByNode($node);
        $this->assign('nodeInfo', $nodeInfo);
        $this->assign('topics', $topics);
        //var_dump($topics);
        $this->assign('node', $node);
        $this->showSidebar('all');//展示侧边栏
        $this->display('Topic/node');
    }
}