*** Settings ***
Documentation     A test suite for add, edit, and delete user.
Library           SeleniumLibrary

*** Variables ***
${ADD_USER_URL}      http://localhost:3000/admin/add_user.php
${USER_MANAGE_URL}  http://localhost:3000/admin/user_manage.php
${BROWSER}        Chrome
${USER_FNAME}    John
${EDITED_USER_FNAME}    Test User123

*** Test Cases ***
Add User
    # Open the Add Clinic page
    Open Browser    ${ADD_USER_URL}    ${BROWSER}
    Title Should Be    Add User

    # Input the clinic name
    Select From List By Label    id=role    Nurse
    Select From List By Label    id=title    MR
    Input Text    id=Fname    ${USER_FNAME}
    Input Text    id=Lname    Doe
    Input Text    id=Email    john.doe@example.com
    Input Text    id=PhoneNumber    1234567890
    Input Text    id=Password    123456
    Select From List By Label    id=City    New York
    Input Text    id=Address    Test Address
    Select From List By Label    id=clinic    PawsCare Center
    Select From List By Label    id=pet    Max
    
    # Click the Add button
    Scroll Element Into View    id=add_user_button
    Click Button    id=add_user_button
    
    # Wait for the clinic name to be visible in the table
    Wait Until Page Contains    ${USER_FNAME}

    [Teardown]    Close Browser

Edit User
    # Open the Clinic Management page
    Open Browser    ${USER_MANAGE_URL}    ${BROWSER}
    Wait Until Page Contains    User Management

    # Get the Edit button for the specific clinic by its ID
    Scroll Element Into View    xpath=//table//td[contains(text(), '${USER_FNAME}')]/following-sibling::td/a[contains(@id, 'edit_button')]
    ${edit_button}=    Get WebElement    xpath=//table//td[contains(text(), '${USER_FNAME}')]/following-sibling::td/a[contains(@id, 'edit_button')]
    Click Element    ${edit_button}
    
    # Edit the clinic name
    Input Text    id=Fname    ${EDITED_USER_FNAME}
    
    # Click the Edit button
    Scroll Element Into View    id=edit_user_button
    Click Button    id=edit_user_button

    # Wait for the clinic to be updated in the table
    Wait Until Page Contains    ${EDITED_USER_FNAME}    timeout=30

    [Teardown]    Close Browser

Delete User
    Open Browser    ${USER_MANAGE_URL}    ${BROWSER}
    Title Should Be    User Management

    # Wait until the clinic name appears in the table
    Wait Until Page Contains    ${EDITED_USER_FNAME}    timeout=30

    # Wait for the clinic to be visible in the table
    Scroll Element Into View    xpath=//table//td[contains(text(), '${EDITED_USER_FNAME}')]/following-sibling::td/a[contains(@id, 'delete_button')]
    ${delete_button}=    Get WebElement    xpath=//table//td[contains(text(), '${EDITED_USER_FNAME}')]/following-sibling::td/a[contains(@id, 'delete_button')]
    Click Element    ${delete_button}

    # Validate that the clinic has been deleted
    Wait Until Page Does Not Contain    ${EDITED_USER_FNAME}    timeout=30

    [Teardown]    Close Browser