<?php

namespace CardBattleGame\Tests\Functional\Application;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

trait CqrsContextTrait
{
    /**
     * @var CqrsContext
     */
    private $cqrsContext;

    /** @BeforeScenario */
    public function attachCqrsToApplicationContext(BeforeScenarioScope $scope)
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();
        $this->cqrsContext = $environment->getContext(CqrsContext::class);
    }
}
