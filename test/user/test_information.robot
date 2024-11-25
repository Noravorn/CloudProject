*** Settings ***
Documentation     A test suite for valid login.
Library           SeleniumLibrary
Resource          login_keywords.robot
Resource          logout_keywords.robot

*** Variables ***
${INFORMATION URL}      http://localhost:3000/information.php
${BROWSER}        Chrome
${EMAIL}          michael.b@email.com
${PASSWORD}       test3

*** Test Cases ***
Valid Information
    # Logout
    Open Browser To Logout Page
    Home Page Should Be Open
    
    # Login
    Open Browser To Login Page
    Input Username and Password    ${EMAIL}    ${PASSWORD}
    Submit Credentials
    Welcome Page Should Be Open
    
    Click Sidebar Link    information_patient
    Page Should Contain    Patient Information

    Click Sidebar Link    information_pet
    Page Should Contain    Pet Information

    Click Sidebar Link    information_history
    Page Should Contain    Donation History

    [Teardown]    Close Browser

*** Keywords ***
Click Sidebar Link
    [Arguments]    ${section}
    [Documentation]    Click a sidebar link based on its data-section attribute.
    Click Element    css=#sidebar a[data-section="${section}"]
