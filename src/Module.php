<?php
/**
 * ZfDebugModule. Console commands and other utilities for debugging ZF2 apps.
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2016 Vítor Brandão <vitor@noiselabs.org>
 */

namespace Noiselabs\ZfDebugModule;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;

/**
 * ZfDebug Module.
 *
 * @author Vítor Brandão <vitor@noiselabs.org>
 */
class Module implements ConfigProviderInterface, DependencyIndicatorInterface
{
    const DEFAULT_LAYOUT = 'noiselabs/zf-debug-utils/layout';

    /**
     * {@inheritdoc}
     */
    public function getModuleDependencies()
    {
        return ['AssetManager'];
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return require __DIR__ . '/Resources/config/module.config.php';
    }
}
