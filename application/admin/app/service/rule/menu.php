<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\rule;

use common\is\tree\tree;
use admin\is\repository\admin_menu as repository;

/**
 * 菜单树结构
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.12
 * @version 1.0
 */
class menu
{

    /**
     * 权限仓储
     *
     * @var \admin\is\repository\admin_menu
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\admin_menu $oRepository
     * @return void
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法
     *
     * @return array
     */
    public function run()
    {
        return $this->parseMenuList($this->oRepository->all());
    }

    /**
     * 将节点载入节点树并返回树结构
     *
     * @param \queryyetsimple\support\collection $objMenu
     * @return array
     */
    protected function parseMenuList($objMenu)
    {
        return $this->createTree($objMenu)->forList(function ($arrItem) {
            return array_merge(['id' => $arrItem['value']], $arrItem['data']);
        });
    }

    /**
     * 生成节点树
     *
     * @param \queryyetsimple\support\collection $objMenu
     * @return \common\is\tree\tree
     */
    protected function createTree($objMenu)
    {
        return new tree($this->parseToNode($objMenu));
    }

    /**
     * 转换为节点数组
     *
     * @param \queryyetsimple\support\collection $objMenu
     * @return array
     */
    protected function parseToNode($objMenu)
    {
        $arrNode = [];
        foreach ($objMenu as $oMenu) {
            $arrNode[] = [
                $oMenu->id,
                $oMenu->pid,
                [
                    'title' => $oMenu->title
                ]
            ];
        }
        return $arrNode;
    }
}
