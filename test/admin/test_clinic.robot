*** Settings ***
Documentation     A test suite for add, edit, and delete pet.
Library           SeleniumLibrary

*** Variables ***
${ADD_CLINIC_URL}      http://localhost:3000/admin/add_clinic.php
${CLINIC_MANAGE_URL}  http://localhost:3000/admin/clinic_manage.php
${BROWSER}        Chrome
${CLINIC_NAME}    Sample Clinic
${EDITED_CLINIC_NAME}    Test Clinic123

*** Test Cases ***
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