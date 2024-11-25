*** Settings ***
Documentation     A test suite for valid login/logout.
Library           SeleniumLibrary
Resource          login_keywords.robot
Resource          logout_keywords.robot

*** Variables ***
${LOGIN URL}      http://localhost:3000/admin/login.php
${BROWSER}        Chrome

*** Test Cases ***
Valid Login
    Open Browser To Login Page
    Input Username and Password    sarah.j@email.com    test2 
    Submit Credentials
    Admin Page Should Be Open
    [Teardown]    Close Browser

Valid Logout
    Open Browser To Logout Page
    Login Page Should Be Open
    [Teardown]    Close Browser
