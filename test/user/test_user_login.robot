*** Settings ***
Documentation     A test suite for valid login.
Library           SeleniumLibrary

*** Variables ***
${LOGIN URL}      http://localhost:3000/login.php
${BROWSER}        Chrome

*** Test Cases ***
Valid Login
    Open Browser To Login Page
    Input Username and Password    michael.b@email.com    test3
    Submit Credentials
    Welcome Page Should Be Open
    [Teardown]    Close Browser

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

Welcome Page Should Be Open
    Title Should Be    Information
