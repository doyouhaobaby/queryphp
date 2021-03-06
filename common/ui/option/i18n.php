<?php
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * 国际化默认配置文件
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
return [

    /**
     * ---------------------------------------------------------------
     * 是否开启语言包
     * ---------------------------------------------------------------
     *
     * 如果你的项目需要多语言请设置为 true，否则设置为 false
     */
    'on' => true,

    /**
     * ---------------------------------------------------------------
     * 当前语言环境
     * ---------------------------------------------------------------
     *
     * 根据面向的客户设置当前的软件的语言
     */
    'default' => 'zh-cn',

    /**
     * ---------------------------------------------------------------
     * 当前开发语言环境
     * ---------------------------------------------------------------
     *
     * 如果为当前开发语言则不载入语言包直接返回
     */
    'develop' => 'zh-cn',

    /**
     * ---------------------------------------------------------------
     * 语言包扩展
     * ---------------------------------------------------------------
     *
     * 扩展语言包对应的目录，string or array
     * see mvc\application::getI18nDir
     */
    'extend' => []
];
