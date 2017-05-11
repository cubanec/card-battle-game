@cards-playing
Feature: Playing cards

  Scenario: Damage card can be played
    Given game was created with 2 MP per turn with 20 HP per player
    And player on the move was dealt with card of type "damage" with value "2" and cost of "1" MP
    When player on the move plays the card of type "damage" with value "2" and cost of "1" MP
    Then card of type "damage" with value "2" and cost of "1" MP was played
    And player waiting has 18 HP left
    And player on the move has "1" MP left
