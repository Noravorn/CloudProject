*** Settings ***
Library           SeleniumLibrary

*** Variables ***
${LOGIN URL}      http://ec2-34-238-250-62.compute-1.amazonaws.com/login.php
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

Information Page Should Be Open
    Wait Until Page Contains    Information    timeout=30
