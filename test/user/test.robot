*** Settings ***
Documentation     A test suite for valid login/logout.
Library           SeleniumLibrary
Resource          login_keywords.robot
Resource          logout_keywords.robot

*** Variables ***
${EMAIL}          michael.b@email.com
${PASSWORD}       test3

${SEARCH URL}      http://localhost:3000/search.php
${BROWSER}        Chrome
${PET_SPECIES}    Dog
${BLOOD_TYPE}     DEA 1.1
${CITY}           New York
${SERVICE_HOURS}  Morning

${INFORMATION URL}      http://localhost:3000/information.php

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

Valid Search
    Open Browser    ${SEARCH URL}    ${BROWSER}
    Title Should Be    Search
    
    Wait Until Page Contains    Dog    timeout=30
    Wait Until Page Contains    New York    timeout=30
    Wait Until Page Contains    A    timeout=30
    Wait Until Page Contains    Morning    timeout=30
    
    # Select the values from the dropdowns
    Select From List By Value    id=petSpecies    ${PET_SPECIES}
    Select From List By Value    id=bloodType    ${BLOOD_TYPE}
    Select From List By Value    id=city    ${CITY}
    Select From List By Value    id=serviceHours    ${SERVICE_HOURS}

    # Click the search button
    Click Button    id=search-button
    
    # Wait until there is table tag in the page
    Wait Until Element Is Visible  xpath=//table[@class='table table-bordered']
    Table Should Contain          xpath=//table[@class='table table-bordered']    ${BLOOD_TYPE}
    Table Should Contain          xpath=//table[@class='table table-bordered']    ${CITY}

    [Teardown]    Close Browser

Valid Information
    # Logout
    Open Browser To Logout Page
    Home Page Should Be Open
    
    # Login
    Open Browser To Login Page
    Input Username and Password    ${EMAIL}    ${PASSWORD}
    Submit Credentials
    Information Page Should Be Open
    
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


