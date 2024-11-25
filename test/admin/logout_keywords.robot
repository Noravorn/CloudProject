*** Settings ***
Library           SeleniumLibrary

*** Variables ***
${LOGOUT URL}      http://localhost:3000/admin/logout.php
${BROWSER}        Chrome

*** Keywords ***
Open Browser To Logout Page
    Open Browser    ${LOGOUT URL}    ${BROWSER}

Login Page Should Be Open
    Wait Until Page Contains    Login    timeout=30
