*** Settings ***
Documentation     A test suite for valid login.
Library           SeleniumLibrary

*** Variables ***
${SEARCH URL}      http://localhost:3000/search.php
${BROWSER}        Chrome
${PET_SPECIES}    Dog
${BLOOD_TYPE}     DEA 1.1
${CITY}           New York
${SERVICE_HOURS}  Morning

*** Test Cases ***
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
