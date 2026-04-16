<?php
/**
 * Put common functions for your app here...
 */

// Get specific fields from Filemaker
function getField(string $name, ?array $rec = null) {
    // Uses $current_record if no record explicitly passed.
    // Avoids null issue
    if ($rec === null) {
        if (!isset($GLOBALS['current_record'])) return '';
        $rec = $GLOBALS['current_record'];
    }
    // FileMaker Data API structure: ['fieldData'][<FieldName>]
    return $rec['fieldData'][$name] ?? '';
}

// Shim FileMaker PHP API record objects for legacy templates.
function fm_record_shim(array $row) {
    return new class($row) {
        private $r;
        public function __construct($r) { $this->r = $r; }
        public function getField($name) { return $this->r['fieldData'][$name] ?? ''; }
        public function getRecordID() { return $this->r['recordId'] ?? ''; }
    };
}

// Fetch layout value lists via Data API (used for language list, etc.).
function fm_get_value_lists(string $database, string $layout): array {
    $auth = get_filemaker_auth($database);
    if ($auth === null) {
        return [];
    }

    $endpoint = FM_URL . 'databases/' . rawurlencode($database) . '/layouts/' . rawurlencode($layout) . '/valueLists';
    $response = get_filemaker_data($endpoint, CURLOPT_HTTPGET, $auth);
    $json = json_decode($response, true);
    if (!is_array($json) || 0 !== (int)($json['messages'][0]['code'] ?? 500)) {
        return [];
    }

    return $json['response']['valueLists'] ?? [];
}

/**
 * Get a single record by ID using FileMaker Data API v24
 * 
 * @param string $layout The layout name
 * @param int|string $recordId The record ID
 * @return array|null The record data or null if not found
 */
function fm_get_record(string $layout, $recordId) {
    // Map layout names to database names
    $layoutToDatabase = [
        'web_biblio' => 'Biblio',
        'web_organizations' => 'Organizations',
        'web_mchprojects' => 'MCHProjects',
        'web_hsnrcrefcoll' => 'Biblio', // Assuming HSNRC is in Biblio database
        'ESMs' => 'Biblio',
        'Evidence Literature' => 'Biblio',
    ];
    
    $database = $layoutToDatabase[$layout] ?? 'Biblio'; // Default to Biblio
    
    $req = [
        'database' => $database,
        'layout'   => $layout,
        'action'   => 'single',
        'record'   => (int)$recordId,
    ];
    
    $res = do_filemaker_request($req, 'array');
    $code = (int)($res['messages'][0]['code'] ?? 500);
    
    if ($code === 0 && isset($res['response']['data'][0])) {
        return $res['response']['data'][0];
    }
    
    return null;
}
