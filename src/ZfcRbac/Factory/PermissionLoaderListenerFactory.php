<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace ZfcRbac\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcRbac\Permission\PermissionLoaderListener;

/**
 * Factory to create a permission loader
 */
class PermissionLoaderListenerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     * @return PermissionLoaderListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Zend\Cache\Storage\StorageInterface $cacheStorage */
        $cacheStorage = $serviceLocator->get('ZfcRbac\Cache');

        /* @var \ZfcRbac\Permission\PermissionProviderPluginManager $pluginManager */
        $pluginManager = $serviceLocator->get('ZfcRbac\Permission\PermissionProviderPluginManager');

        /* @var \ZfcRbac\Permission\PermissionProviderChain $permissionProviderChain */
        $permissionProviderChain = $pluginManager->get('ZfcRbac\Permission\PermissionProviderChain');

        return new PermissionLoaderListener($permissionProviderChain, $cacheStorage);
    }
}
