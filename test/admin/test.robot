*** Settings ***
Documentation     A test suite for add, edit, and delete user.
Library           SeleniumLibrary
Resource          login_keywords.robot
Resource          logout_keywords.robot

*** Variables ***
${ADD_USER_URL}      http://localhost:3000/admin/add_user.php
${USER_MANAGE_URL}  http://localhost:3000/admin/user_manage.php
${BROWSER}        Chrome
${USER_FNAME}    John
${EDITED_USER_FNAME}    Test User123

${ADD_CLINIC_URL}      http://localhost:3000/admin/add_clinic.php
${CLINIC_MANAGE_URL}  http://localhost:3000/admin/clinic_manage.php
${BROWSER}        Chrome
${CLINIC_NAME}    Sample Clinic
${EDITED_CLINIC_NAME}    Test Clinic123

${ADD_PET_URL}      http://localhost:3000/admin/add_pet.php
${PET_MANAGE_URL}  http://localhost:3000/admin/pet_page.php
${PET_NAME}    Sample Pet
${EDITED_PET_NAME}    Test Pet123

*** Test Cases ***
Valid Login
    Open Browser To Login Page
    Input Username and Password    sarah.j@email.com    test2 
    Submit Credentials
    Admin Page Should Be Open
    [Teardown]    Close Browser

Valid Logout
    Open Browser To Logout Page
    Login Page Should Be Open
    [Teardown]    Close Browser

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

Add Clinic
    # Open the Add Clinic page
    Open Browser    ${ADD_CLINIC_URL}    ${BROWSER}
    Title Should Be    Add Clinic

    # Input the clinic name
    Input Text    id=Name    ${CLINIC_NAME}
    Select From List By Label    id=City    New York
    Input Text    id=Address    Test Address
    Input Text    id=PhoneNumber    1234567890
    Input Text    id=OpenTime    16:00
    Input Text    id=CloseTime    17:00
    
    # Click the Add button
    Scroll Element Into View    id=add_clinic_button
    Click Button    id=add_clinic_button
    
    # Wait for the clinic name to be visible in the table
    Wait Until Page Contains    ${CLINIC_NAME}

    [Teardown]    Close Browser

Edit Clinic
    # Open the Clinic Management page
    Open Browser    ${CLINIC_MANAGE_URL}    ${BROWSER}
    Title Should Be    Clinic Management

    # Get the Edit button for the specific clinic by its ID
    ${edit_button}=    Get WebElement    xpath=//table//td[contains(text(), '${CLINIC_NAME}')]/following-sibling::td/a[contains(@id, 'edit_button')]
    Click Element    ${edit_button}
    
    # Edit the clinic name
    Input Text    id=Name    ${EDITED_CLINIC_NAME}
    
    # Click the Edit button
    Scroll Element Into View    id=edit_clinic_button
    Click Button    id=edit_clinic_button

    # Wait for the clinic to be updated in the table
    Wait Until Page Contains    ${EDITED_CLINIC_NAME}    timeout=30

    [Teardown]    Close Browser

Delete Clinic
    Open Browser    ${CLINIC_MANAGE_URL}    ${BROWSER}
    Title Should Be    Clinic Management

    # Wait until the clinic name appears in the table
    Wait Until Page Contains    ${EDITED_CLINIC_NAME}    timeout=30

    # Wait for the clinic to be visible in the table
    ${delete_button}=    Get WebElement    xpath=//table//td[contains(text(), '${EDITED_CLINIC_NAME}')]/following-sibling::td/a[contains(@id, 'delete_button')]
    Click Element    ${delete_button}

    # Validate that the clinic has been deleted
    Wait Until Page Does Not Contain    ${EDITED_CLINIC_NAME}    timeout=30

    [Teardown]    Close Browser


Add Pet
    Open Browser    ${ADD_PET_URL}    ${BROWSER}
    Title Should Be    Add Pet

    # Input the pet name
    Input Text    id=Name    ${PET_NAME}
    Select From List By Label    id=petType    Dog
    Select From List By Value    id=bloodType   1
    Input Text    id=Breed    Test Breed
    Input Text    id=Age    10

    # Click the Add button
    Scroll Element Into View    id=add_pet_button
    Click Button    id=add_pet_button

    # Wait for the pet name to be visible in the table
    Wait Until Page Contains    ${PET_NAME}

    [Teardown]    Close Browser

Edit Pet
    Open Browser    ${PET_MANAGE_URL}    ${BROWSER}
    Title Should Be    Pet Page

    # Get the Edit button for the specific clinic by its ID
    Scroll Element Into View    xpath=//table//td[contains(text(), '${PET_NAME}')]/following-sibling::td/a[contains(@id, 'edit_button')]
    ${edit_button}=    Get WebElement    xpath=//table//td[contains(text(), '${PET_NAME}')]/following-sibling::td/a[contains(@id, 'edit_button')]
    Click Element    ${edit_button}

    # Edit the pet name
    Input Text    id=Name    ${EDITED_PET_NAME}

    # Click the Edit button
    Scroll Element Into View    id=edit_pet_button
    Click Button    id=edit_pet_button

    # Wait for the pet to be updated in the table
    Wait Until Page Contains    ${EDITED_PET_NAME}    timeout=30

    [Teardown]    Close Browser

Delete Pet
    Open Browser    ${PET_MANAGE_URL}    ${BROWSER}
    Title Should Be    Pet Page

    # Wait until the pet name appears in the table
    Wait Until Page Contains    ${EDITED_PET_NAME}    timeout=30

    # Wait for the pet to be visible in the table
    ${delete_button}=    Get WebElement    xpath=//table//td[contains(text(), '${EDITED_PET_NAME}')]/following-sibling::td/a[contains(@id, 'delete_button')]
    Click Element    ${delete_button}

    # Validate that the pet has been deleted
    Wait Until Page Does Not Contain    ${EDITED_PET_NAME}    timeout=30

    [Teardown]    Close Browser
