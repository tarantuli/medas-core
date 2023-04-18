<?php

namespace PHPSTORM_META {

    use Medas\Core\Interfaces\{ObjectInstantiator, ServiceManager};

    override(ServiceManager::resolve(), map([
        '' => '@',
    ]));

    override(ObjectInstantiator::instantiate(), map([
        '' => '@',
    ]));

    override(\service(), map([
        '' => '@',
    ]));

    override(\attribute(), map([
        '' => '@',
    ]));
}
