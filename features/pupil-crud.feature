Feature: I would like to edit pupils

  Scenario Outline: Insert records
   Given I am on homepage
     And I follow "Login"
     And I fill in "Username" with "admin"
     And I fill in "Password" with "loremipsum"
     And I press "Login"
     And I go to "/admin/pupil"
    Then I should not see "<surname>"
     And I follow "Create a new entry"
    Then I should see "Pupil creation"
    When I fill in "Name" with "<name>"
     And I fill in "Surname" with "<surname>"
     And I press "Create"
    Then I should see "<surname>"

  Examples:
    | name                     | surname              |
    | PUPIL RECORD John        | PUPIL RECORD Doe     |
    | PUPIL RECORD Peter       | PUPIL RECORD Black   |
    | PUPIL RECORD Ann         | PUPIL RECORD Green   |


  Scenario Outline: Edit records
   Given I am on homepage
     And I follow "Login"
     And I fill in "Username" with "admin"
     And I fill in "Password" with "loremipsum"
     And I press "Login"
     And I go to "/admin/pupil"
    Then I should not see "<new-surname>"
    When I follow "<old-surname>"
    Then I should see "<old-surname>"
    When I follow "Edit"
     And I fill in "Name" with "<new-name>"
     And I fill in "Surname" with "<new-surname>"
     And I press "Update"
     And I follow "Back to the list"
    Then I should see "<new-surname>"
     And I should not see "<old-surname>"

  Examples:
    | old-surname         | new-name                 | new-surname            |
    | PUPIL RECORD Doe    | NEW PUPIL RECORD Johnny | NEW PUPIL RECORD DoeEEE |


  Scenario Outline: Delete records
   Given I am on homepage
     And I follow "Login"
     And I fill in "Username" with "admin"
     And I fill in "Password" with "loremipsum"
     And I press "Login"
     And I go to "/admin/pupil"
    Then I should see "<surname>"
    When I follow "<surname>"
    Then I should see "<surname>"
    When I press "Delete"
    Then I should not see "<surname>"

  Examples:
    |  surname                |
    | PUPIL RECORD Black      |
    | PUPIL RECORD Green      |
    | NEW PUPIL RECORD DoeEEE |