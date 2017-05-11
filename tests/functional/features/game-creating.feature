@game-creating
Feature: Creating the game

  Scenario: Game can be created
    When new game is created with 2 MP per turn with 20 HP per player
    Then the game should be created
    And player on the move has "2" MP left
    And player waiting has 20 HP left
    And player on turn has 20 HP left
