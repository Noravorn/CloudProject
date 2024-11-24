*** Settings ***
Documentation     A test suite for add, edit, and delete pet.
Library           SeleniumLibrary

*** Variables ***
${ADD_CLINIC_URL}      http://localhost:3000/admin/add_clinic.php
${EDIT_CLINIC_URL}    http://localhost:3000/admin/edit_clinic.php
${CLINIC_MANAGE_URL}  http://localhost:3000/admin/clinic_manage.php
${BROWSER}        Chrome

*** Test Cases ***
Add Clinic
    Open Browser To Add Clinic Page
    [Teardown]    Close Browser

Edit Clinic
    Open Browser To Edit Clinic Page
    [Teardown]    Close Browser

*** Keywords ***
Open Browser To Add Clinic Page
    Open Browser    ${ADD_CLINIC_URL}    ${BROWSER}
    Title Should Be    Add Clinic

Insert Clinic Data
    Input Text    id=Name    Test Clinic
    Input Text    id=City    Test City
    Input Text    id=Address    Test Address
    Input Text    id=PhoneNumber    1234567890
    Input Text    id=OpenTime    09:00
    Input Text    id=CloseTime    17:00
    Click Button    id=add_clinic_button

Open Browser To Edit Clinic Page
    Open Browser    ${EDIT_CLINIC_URL}    ${BROWSER}
    Title Should Be    Edit Clinic

Edit Clinic Data
    Input Text    id=Name    Test Clinic123
    Input Text    id=City    Test City
    Input Text    id=Address    Test Address
    Input Text    id=PhoneNumber    1234567890
    Input Text    id=OpenTime    09:00
    Input Text    id=CloseTime    17:00
    Click Button    id=edit_clinic_button

Open Browser To Clinic Manage Page
    Open Browser    ${CLINIC_MANAGE_URL}    ${BROWSER}
    Title Should Be    Clinic Manage

Select Clinic To Delete
    [Documentation]  Click the delete button of the first clinic in the list.
    Click Element  xpath=(//a[contains(@class, 'btn-danger')])[1]



