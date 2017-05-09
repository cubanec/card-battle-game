@cards-dealing
Feature: Dealing cards

  Scenario:
    Given new game is created with 2 MP per turn with 20 HP per player
    When card of type "damage" with value "2" HP and cost of "1" MP is dealt for player on turn
    Then player on turn has on hand card of type "damage" with value "2" HP and cost of "1" MP