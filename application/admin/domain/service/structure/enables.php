<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\domain\service\structure;

use admin\is\repository\structure as repository;

/**
 * 后台部门启用禁用服务
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class enables
{

    /**
     * 后台部门仓储
     *
     * @var \admin\is\repository\structure
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\structure $oRepository
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
     * @param string $strType
     * @return void
     */
    public function run($arrId, $strStatus)
    {
        $this->checkStatus($strStatus);
        $this->registerUnitOfWork($this->queryStructures($arrId), $strStatus);
        $this->commit();
    }

    /**
     * 验证启用禁用状态
     *
     * @param string $strStatus
     * @return void
     */
    protected function checkStatus($strStatus)
    {
        if (! in_array($strStatus, [
            'disable',
            'enable'
        ])) {
            throw new enables_failed(__('启用禁用状态不受支持'));
        }
    }

    /**
     * 注册工作单元
     *
     * @param \queryyetsimple\support\collection $objCollection
     * @param string $strStatu
     * @return void
     */
    protected function registerUnitOfWork($objCollection, $strStatus)
    {
        foreach ($objCollection as $objStructure) {
            $objStructure->forceProp('status', $strStatus);
            $this->oRepository->registerUpdate($objStructure);
        }
    }

    /**
     * 提交工作单元
     *
     * @return void
     */
    protected function commit()
    {
        $this->oRepository->registerCommit();
    }

    /**
     * 查找指定 ID 的部门
     *
     * @param array $arrIds
     * @return \queryyetsimple\support\collection
     */
    protected function queryStructures(array $arrIds)
    {
        return $this->oRepository->all(function ($oSelect) use ($arrIds) {
            $oSelect->where('id', 'in', $arrIds)->setColumns('id');
        });
    }
}
