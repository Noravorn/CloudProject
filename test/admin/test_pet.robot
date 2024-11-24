*** Settings ***
Documentation     A test suite for add, edit, and delete pet.
Library           SeleniumLibrary

*** Variables ***
${ADD_PET_URL}      http://localhost:3000/admin/add_pet.php
${EDIT_PET_URL}    http://localhost:3000/admin/edit_pet.php
${PET_PAGE_URL}  http://localhost:3000/admin/pet_page.php
${BROWSER}        Chrome

*** Test Cases ***
Add Pet
    Open Browser To Add Pet Page
    [Teardown]    Close Browser

Edit Pet
    Open Browser To Edit Pet Page
    [Teardown]    Close Browser

*** Keywords ***
Open Browser To Add Pet Page
    Open Browser    ${ADD_PET_URL}    ${BROWSER}
    Title Should Be    Add Pet
    Click Button    id=add_pet_button
