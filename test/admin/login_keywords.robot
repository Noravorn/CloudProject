*** Settings ***
Library           SeleniumLibrary

*** Variables ***
${LOGIN URL}      http://localhost:3000/admin/login.php
${BROWSER}        Chrome

*** Keywords ***
Open Browser To Login Page
    Open Browser    ${LOGIN URL}    ${BROWSER}
    Title Should Be    Login

Input Username and Password
    [Arguments]    ${email}    ${password}
    Input Text    id=email    ${email}
    Input Text    id=password    ${password}

Submit Credentials
    Click Button    id=login_button

Admin Page Should Be Open
    Wait Until Page Contains    Admin    timeout=30

