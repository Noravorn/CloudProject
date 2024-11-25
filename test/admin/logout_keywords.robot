*** Settings ***
Library           SeleniumLibrary

*** Variables ***
${LOGOUT URL}      http://ec2-34-238-250-62.compute-1.amazonaws.com/admin/logout.php
${BROWSER}        Chrome

*** Keywords ***
Open Browser To Logout Page
    Open Browser    ${LOGOUT URL}    ${BROWSER}

Login Page Should Be Open
    Wait Until Page Contains    Login    timeout=30
