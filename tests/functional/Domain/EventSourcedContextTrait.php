<?php

namespace CardBattleGame\Tests\Functional\Domain;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

trait EventSourcedContextTrait
{
    /**
     * @var EventSourcedContext
     */
    private $eventSourcedContext;

    /** @BeforeScenario */
    public function attachToApplicationContext(BeforeScenarioScope $scope)
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();
        $this->eventSourcedContext = $environment->getContext(EventSourcedContext::class);
    }
}
