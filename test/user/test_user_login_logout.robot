*** Settings ***
Documentation     A test suite for valid login/logout.
Library           SeleniumLibrary
Resource          login_keywords.robot
Resource          logout_keywords.robot

*** Variables ***
${EMAIL}          michael.b@email.com
${PASSWORD}       test3

*** Test Cases ***
Valid Login
    Open Browser To Login Page
    Input Username and Password    ${EMAIL}    ${PASSWORD}
    Submit Credentials
    Information Page Should Be Open
    [Teardown]    Close Browser

Valid Logout
    Open Browser To Logout Page
    Home Page Should Be Open
    [Teardown]    Close Browser

