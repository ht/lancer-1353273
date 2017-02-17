<?php
/*
 * This file is part of the ProductSortColumn
 *
 * Copyright(c) 2017 izayoi256 All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ProductSortColumn;

use Eccube\Application;
use Eccube\Plugin\AbstractPluginManager;

class PluginManager extends AbstractPluginManager
{
    /**
     * @param $config
     * @param Application $app
     */
    public function install($config, Application $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Resource/doctrine/migration', $config['code']);
    }

    /**
     * @param $config
     * @param Application $app
     */
    public function uninstall($config, Application $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Resource/doctrine/migration', $config['code'], 0);
    }

    /**
     * @param $config
     * @param Application $app
     */
    public function enable($config, Application $app)
    {
    }

    /**
     * @param $config
     * @param Application $app
     */
    public function disable($config, Application $app)
    {
    }

    /**
     * @param $config
     * @param Application $app
     */
    public function update($config, Application $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Resource/doctrine/migration', $config['code']);
    }
}
