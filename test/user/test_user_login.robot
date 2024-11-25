*** Settings ***
Documentation     A test suite for valid login.
Library           SeleniumLibrary
Resource          login_keywords.robot

*** Variables ***
${EMAIL}          michael.b@email.com
${PASSWORD}       test3

*** Test Cases ***
Valid Login
    Open Browser To Login Page
    Input Username and Password    ${EMAIL}    ${PASSWORD}
    Submit Credentials
    Welcome Page Should Be Open
    [Teardown]    Close Browser