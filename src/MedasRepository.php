<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Holds the active service manager and object instantiator, for the global functions like `service()`. `medas()`
 * returns the instance.
 *
 * @state Keeps both for the lifetime of the process, or until `medas(true)` replaces the repository.
 */
class MedasRepository
{
    private Interfaces\ServiceManager $serviceManager;
    private Interfaces\ObjectInstantiator $objectInstantiator;

    /**
     * @throws Exceptions\NoServiceManagerRegistered When none has been set yet.
     */
    public function serviceManager(): Interfaces\ServiceManager
    {
        if (!isset($this->serviceManager)) {
            throw new Exceptions\NoServiceManagerRegistered();
        }

        return $this->serviceManager;
    }

    /**
     * Replaces the active service manager. The service manager calls this itself.
     */
    public function setServiceManager(Interfaces\ServiceManager $serviceManager): void
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @throws Exceptions\NoObjectInstantiatorRegistered When none has been set yet.
     */
    public function objectInstantiator(): Interfaces\ObjectInstantiator
    {
        if (!isset($this->objectInstantiator)) {
            throw new Exceptions\NoObjectInstantiatorRegistered();
        }

        return $this->objectInstantiator;
    }

    /**
     * Replaces the active object instantiator. The service manager calls this itself.
     */
    public function setObjectInstantiator(Interfaces\ObjectInstantiator $objectInstantiator): void
    {
        $this->objectInstantiator = $objectInstantiator;
    }
}
