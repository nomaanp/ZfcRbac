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

namespace ZfcRbac\Options;

use Zend\Stdlib\AbstractOptions;
use ZfcRbac\Exception;
use ZfcRbac\Guard\GuardInterface;

/**
 * Options for ZfcRbac module
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * Key of the identity provider used to retrieve the identity
     *
     * @var string
     */
    protected $identityProvider = 'ZfcRbac\Identity\AuthenticationIdentityProvider';

    /**
     * Should the RBAC container automatically create roles for missing roles?
     *
     * @var bool
     */
    protected $createMissingRoles = true;

    /**
     * Guest role (used when no identity is found)
     *
     * @var string
     */
    protected $guestRole = 'guest';

    /**
     * Should we force reload of roles and permissions each time "isGranted" is called?
     *
     * @var bool
     */
    protected $forceReload = false;

    /**
     * Guards
     *
     * @var array
     */
    protected $guards = [];

    /**
     * Protection policy for guards (can be "deny" or "allow")
     *
     * @var string
     */
    protected $protectionPolicy = GuardInterface::POLICY_DENY;

    /**
     * A configuration for role providers
     *
     * @var array
     */
    protected $roleProviders = [];

    /**
     * A configuration for permission providers
     *
     * @var array
     */
    protected $permissionProviders = [];

    /**
     * Options for the unauthorized strategy
     *
     * @var UnauthorizedStrategyOptions|null
     */
    protected $unauthorizedStrategy;

    /**
     * Options for the redirect strategy
     *
     * @var RedirectStrategyOptions|null
     */
    protected $redirectStrategy;

    /**
     * Either a string fetched from service locator, or a StorageFactory compliant config
     *
     * @var string|array
     */
    protected $cache;

    /**
     * Constructor
     *
     * {@inheritDoc}
     */
    public function __construct($options = null)
    {
        $this->__strictMode__ = false;
        parent::__construct($options);
    }

    /**
     * Set the key of the identity provider used to retrieve the identity
     *
     * @param  string $identityProvider
     * @return void
     */
    public function setIdentityProvider($identityProvider)
    {
        $this->identityProvider = (string) $identityProvider;
    }

    /**
     * Get the key of the identity provider used to retrieve the identity
     *
     * @return string
     */
    public function getIdentityProvider()
    {
        return $this->identityProvider;
    }

    /**
     * Should the RBAC container automatically create roles for missing roles?
     *
     * @param boolean $createMissingRoles
     */
    public function setCreateMissingRoles($createMissingRoles)
    {
        $this->createMissingRoles = (bool) $createMissingRoles;
    }

    /**
     * Retrieve if the RBAC container should automatically create roles for missing roles
     *
     * @return boolean
     */
    public function getCreateMissingRoles()
    {
        return $this->createMissingRoles;
    }

    /**
     * Set the guest role (used when no identity is found)
     *
     * @param string $guestRole
     */
    public function setGuestRole($guestRole)
    {
        $this->guestRole = (string) $guestRole;
    }

    /**
     * Get the guest role (used when no identity is found)
     *
     * @return string
     */
    public function getGuestRole()
    {
        return $this->guestRole;
    }

    /**
     * Set if we should force reloading the roles and permissions whenever "isGranted" is called
     *
     * @param  boolean $forceReload
     * @return void
     */
    public function setForceReload($forceReload)
    {
        $this->forceReload = (bool) $forceReload;
    }

    /**
     * Get if we should force reloading the roles and permissions whenever "isGranted" is called
     *
     * @return boolean
     */
    public function getForceReload()
    {
        return $this->forceReload;
    }

    /**
     * Set the guards options
     *
     * @param  array $guards
     * @return void
     */
    public function setGuards(array $guards)
    {
        $this->guards = $guards;
    }

    /**
     * Get the guards options
     *
     * @return array
     */
    public function getGuards()
    {
        return $this->guards;
    }

    /**
     * Set the protection policy for guards
     *
     * @param  string $protectionPolicy
     * @throws Exception\RuntimeException
     * @return void
     */
    public function setProtectionPolicy($protectionPolicy)
    {
        if ($protectionPolicy !== GuardInterface::POLICY_ALLOW && $protectionPolicy !== GuardInterface::POLICY_DENY) {
            throw new Exception\RuntimeException(sprintf(
                'An invalid protection policy was set. Can only be "deny" or "allow", "%s" given',
                $protectionPolicy
            ));
        }

        $this->protectionPolicy = (string) $protectionPolicy;
    }

    /**
     * Get the protection policy for guards
     *
     * @return string
     */
    public function getProtectionPolicy()
    {
        return $this->protectionPolicy;
    }

    /**
     * Set the configuration for role providers
     *
     * @param array $roleProviders
     */
    public function setRoleProviders(array $roleProviders)
    {
        $this->roleProviders = $roleProviders;
    }

    /**
     * Get the configuration for role providers
     *
     * @return array
     */
    public function getRoleProviders()
    {
        return $this->roleProviders;
    }

    /**
     * Set the configuration for permission providers
     *
     * @param array $permissionProviders
     */
    public function setPermissionProviders(array $permissionProviders)
    {
        $this->permissionProviders = $permissionProviders;
    }

    /**
     * Get the configuration for permission providers
     *
     * @return array
     */
    public function getPermissionProviders()
    {
        return $this->permissionProviders;
    }

    /**
     * Set the unauthorized strategy options
     *
     * @param array $unauthorizedStrategy
     */
    public function setUnauthorizedStrategy(array $unauthorizedStrategy)
    {
        $this->unauthorizedStrategy = new UnauthorizedStrategyOptions($unauthorizedStrategy);
    }

    /**
     * Get the unauthorized strategy options
     *
     * @return UnauthorizedStrategyOptions
     */
    public function getUnauthorizedStrategy()
    {
        if (null === $this->unauthorizedStrategy) {
            $this->unauthorizedStrategy = new UnauthorizedStrategyOptions();
        }

        return $this->unauthorizedStrategy;
    }

    /**
     * Set the redirect strategy options
     *
     * @param array $redirectStrategy
     */
    public function setRedirectStrategy(array $redirectStrategy)
    {
        $this->redirectStrategy = new RedirectStrategyOptions($redirectStrategy);
    }

    /**
     * Get the redirect strategy options
     *
     * @return RedirectStrategyOptions
     */
    public function getRedirectStrategy()
    {
        if (null === $this->redirectStrategy) {
            $this->redirectStrategy = new RedirectStrategyOptions();
        }

        return $this->redirectStrategy;
    }

    /**
     * Set the cache config of key
     *
     * @param  array|string $cache
     * @return void
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get the cache config or key
     *
     * @return array|string
     */
    public function getCache()
    {
        return $this->cache;
    }
}
