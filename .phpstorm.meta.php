<?php

namespace PHPSTORM_META {

    use Medas\Core\Interfaces\{ImplementorFinder, ObjectInstantiator, ServiceManager};
    use Medas\Core\SingletonManager;

    override(ServiceManager::resolve(), map([
        '' => '@',
    ]));

    override(ObjectInstantiator::instantiate(), map([
        '' => '@',
    ]));

    override(\service(), map([
        '' => '@',
    ]));

    override(ImplementorFinder::find(), map([
        '' => '@[]',
    ]));
    override(\attribute(), map([

        '' => '@',
    ]));

    override(SingletonManager::get(), map([
        '' => '@',
    ]));
}
