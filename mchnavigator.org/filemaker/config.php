<?php
/**
 * Define accounts here, so the main API file can remain untouched.
 */

// Error messages, uncomment if you need them.
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

/**
 * Generate the authorization header for the API. This is good for 15 minutes after the last use, so we will store that info in the SESSION, otherwise we connect and get new credentials.
 *
 * @param string $database The database to connect to.
 */
function set_filemaker_auth( $database ) {
    $creds = [
        'Biblio'         => 'strategies:RJ1Jng#DYAWe$2C5ZHXKmG2kw^xucTjm@1FMh#',
        'Organizations'  => 'organizations:mchORGANIZATION123!',
        'MCHProjects'    => 'MCHProjectsDataAPI:dataAPIMCHProjects1234!',
        'MCH_Courses'    => 'MCH_Courses:dataAPIMCHCourses1234!',
        'MCH_Navigator'  => 'NCEMCHDataAPI:NCEMCHDataAPI',
        'MCH-Navigator'  => 'NCEMCHDataAPI:NCEMCHDataAPI',
    ];

    if (!isset($creds[$database])) {
        return null;
    }

    return base64_encode($creds[$database]);
}
