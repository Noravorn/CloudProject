*** Settings ***
Library           SeleniumLibrary

*** Variables ***
${LOGOUT URL}      http://ec2-34-238-250-62.compute-1.amazonaws.com/logout.php
${BROWSER}        Chrome

*** Keywords ***
Open Browser To Logout Page
    Open Browser    ${LOGOUT URL}    ${BROWSER}

Home Page Should Be Open
    Wait Until Page Contains    Home    timeout=30
