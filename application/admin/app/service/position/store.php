<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\position;

use common\is\tree\tree;
use admin\domain\entity\admin_position as entity;
use admin\is\repository\admin_position as repository;

/**
 * 后台职位新增保存
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class store
{

    /**
     * 后台职位仓储
     *
     * @var \admin\is\repository\admin_position
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\admin_position $oRepository
     * @return void
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法
     *
     * @param array $aStructure
     * @return array
     */
    public function run($aStructure)
    {
        $aStructure['pid'] = $this->parseParentId($aStructure['pid']);
        return $this->oRepository->create($this->entity($aStructure));
    }

    /**
     * 创建实体
     *
     * @param array $aStructure
     * @return \admin\domain\entity\admin_position
     */
    protected function entity(array $aStructure)
    {
        return new entity($this->data($aStructure));
    }

    /**
     * 组装 POST 数据
     *
     * @param array $aStructure
     * @return array
     */
    protected function data(array $aStructure)
    {
        return [
            'name' => $aStructure['name'],
            'pid' => intval($aStructure['pid']),
            'sort' => 500
        ];
    }

    /**
     * 分析父级数据
     *
     * @param array $aPid
     * @return int
     */
    protected function parseParentId(array $aPid)
    {
        $intPid = intval(array_pop($aPid));
        if ($intPid < 0) {
            $intPid = 0;
        }

        return $intPid;
    }
}
