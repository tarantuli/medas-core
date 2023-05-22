<?php

declare(strict_types=1);

namespace Medas\Core;

class MedasRepository
{
    private Interfaces\ServiceManager $serviceManager;
    private Interfaces\ObjectInstantiator $objectInstantiator;

    public function serviceManager(): Interfaces\ServiceManager
    {
        if (!isset($this->serviceManager)) {
            throw new Exceptions\NoServiceManagerRegistered();
        }

        return $this->serviceManager;
    }

    public function setServiceManager(Interfaces\ServiceManager $serviceManager): void
    {
        $this->serviceManager = $serviceManager;
    }

    public function objectInstantiator(): Interfaces\ObjectInstantiator
    {
        if (!isset($this->objectInstantiator)) {
            throw new Exceptions\NoObjectInstantiatorRegistered();
        }

        return $this->objectInstantiator;
    }

    public function setObjectInstantiator(Interfaces\ObjectInstantiator $objectInstantiator): void
    {
        $this->objectInstantiator = $objectInstantiator;
    }
}
