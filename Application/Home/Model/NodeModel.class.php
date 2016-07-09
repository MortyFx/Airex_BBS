<?php
/**
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
namespace Home\Model;

use Think\Model;

/**
 * 节点模型
 */
class NodeModel extends Model {
    /**
     * 获取最热节点
     * @return [type] [description]
     */
    public function getHotNodes() {
        $nodes = $this->field('node_name')->order('hits desc')->limit(10)->select();
        return $nodes;
    }

    /**
     * 获取全部节点
     * @return [type] [description]
     */
    public function getAllNodes() {
        $nodes = $this->field('id,node_name')->select();
        return $nodes;
    }

    /**
     * 根据分类名获取节点
     * @param  [type] $catName [description]
     * @return [type]          [description]
     */
    public function getNodeByCatName($catName = '') {
        if ($catName == '') {
            $catId = $this->getField('id');
            $nodes = $this->where(array('pid' => $catId))
                ->field('node_name')
                ->select();
            return $nodes;
        } else {
            $nodes = $this->field('node_name')
                ->join('airex_category as c on c.id = pid')
                ->where(array('cat_name' => $catName))
                ->select();
            return $nodes;
        }
    }

    /**
     * 获取节信息
     * @param  [type] $node [description]
     * @return [type]       [description]
     */
    public function getNodeInfo($node) {
        $data = $this->field('id,desc,logo_path,topic_num,desc')
            ->where(array('node_name' => $node))
            ->select()[0];
        return $data;
    }

    /**
     * 根据分类id获取分类节点id
     * @param  [type] $nodeId [description]
     * @return [type]         [description]
     */
    public function getCatIdByNodeId($nodeId) {
        $catId = $this->where(array('id' => $nodeId))->getField('pid');
        return $catId;
    }

    /**
     * 根据tid获取其节点名
     * @param  [type] $tid [description]
     * @return [type]      [description]
     */
    public function getNodeByTid($tid) {
        $node = $this->join('airex_topic as t on t.node_id = airex_node.id')
            ->where(array('t.id' => $tid))
            ->getField('node_name');
        return $node;
    }
}