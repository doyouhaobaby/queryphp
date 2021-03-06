<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\structure;

use common\is\tree\tree;
use admin\is\repository\admin_structure as repository;

/**
 * 后台部门编辑
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class edit
{

    /**
     * 后台部门仓储
     *
     * @var \admin\is\repository\admin_structure
     */
    protected $oRepository;

    /**
     * 父级部门
     *
     * @var int
     */
    protected $intParentId;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\admin_structure $oRepository
     * @return void
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法
     *
     * @param int $intId
     * @return array
     */
    public function run($intId)
    {
        $arrStructure = $this->oRepository->find($intId)->toArray();
        $arrSelect = $this->getSelectTree($arrStructure['pid']);
        $arrStructure['pid'] = $arrSelect['selected'] ?  : [
            - 1
        ];

        return [
            'one' => $arrStructure,
            'list' => $arrSelect['list']
        ];
    }

    /**
     * 分析树结构数据
     *
     * @param int $intParentId
     * @return array
     */
    protected function getSelectTree($intParentId)
    {
        $this->intParentId = $intParentId;
        return $this->parseStructureList($this->oRepository->all());
    }

    /**
     * 将节点载入节点树并返回树结构
     *
     * @param \queryyetsimple\support\collection $objStructure
     * @return array
     */
    protected function parseStructureList($objStructure)
    {
        return $this->createTree($objStructure)->forSelect($this->intParentId);
    }

    /**
     * 生成节点树
     *
     * @param \queryyetsimple\support\collection $objStructure
     * @return \common\is\tree\tree
     */
    protected function createTree($objStructure)
    {
        $oTree = new tree($this->parseToNode($objStructure));
        $arrTopStructure = $this->oRepository->topNode();
        $oTree->setNode($arrTopStructure['id'], $arrTopStructure['pid'], $arrTopStructure['lable'], true);
        return $oTree;
    }

    /**
     * 转换为节点数组
     *
     * @param \queryyetsimple\support\collection $objStructure
     * @return array
     */
    protected function parseToNode($objStructure)
    {
        $arrNode = [];
        foreach ($objStructure as $oStructure) {
            $arrNode[] = [
                $oStructure->id,
                $oStructure->pid,
                $oStructure->name
            ];
        }
        return $arrNode;
    }
}
