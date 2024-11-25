*** Settings ***
Library           SeleniumLibrary

*** Variables ***
${LOGOUT URL}      http://localhost:3000/logout.php
${BROWSER}        Chrome

*** Keywords ***
Open Browser To Logout Page
    Open Browser    ${LOGOUT URL}    ${BROWSER}

Home Page Should Be Open
    Wait Until Page Contains    Home    timeout=30
