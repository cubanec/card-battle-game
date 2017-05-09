@game-creating
Feature: Creating the game

  Scenario: Game can be created
    Given new game is created with 2 MP per turn with 20 HP per player
    Then the game should be created
