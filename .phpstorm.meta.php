<?php

namespace PHPSTORM_META {

    use Medas\Core\Interfaces\{
        EventDispatcher,
        ImplementorFinder,
        InstantiatesLazily,
        ObjectInstantiator,
        ResolvesLazily,
        ServiceManager
    };
    use Medas\Core\SingletonStore;

    override(ServiceManager::resolve(), map([
        '' => '@',
    ]));

    override(ObjectInstantiator::instantiate(), map([
        '' => '@',
    ]));

    override(ResolvesLazily::resolveLazy(), map([
        '' => '@',
    ]));

    override(InstantiatesLazily::instantiateLazy(), map([
        '' => '@',
    ]));

    override(\service(), map([
        '' => '@',
    ]));

    override(\attribute(), map([

        '' => '@',
    ]));

    override(SingletonStore::get(), map([
        '' => '@',
    ]));

    override(\singleton(), map([
        '' => '@',
    ]));

    override(EventDispatcher::dispatch(), type(0));

    override(\dispatch(), type(0));

    override(EventDispatcher::lazyDispatch(), map([
        '' => '@|null',
    ]));
}
