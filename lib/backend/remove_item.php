<?php
session_start();

/*
====================================================================================================
                                        EXPECTED VARIABLES
====================================================================================================

$_POST: 
    > 'sender'      : relative path (relative to frontend/index.php) of the calling script
    
$_SESSION:
    > 'rm_info'  : array of information about a raw material if one was scanned
    > 'dispersion_info'  : array of information about a dispersion if one was scanned

====================================================================================================
                                    VARIABLES SET BEFORE RETURN
====================================================================================================

$_SESSION:
    > 'status' :String             
    : what status the of the calling page should be (one of    '',    'info')
    
    > 'err_msg' :String 
    : any error message to be used in calling script
    
    > 'success_msg' :String        
    : any success message to be used in calling script 
    
    > 'rm_info' :Array      
    : retrieved information about a raw material
    
    > 'dispersion_info' :Array
    : retrieved information about a dispersion

    ================================================================================================
*/

$sender = $_POST['sender']; // address this script was invoked from
$destination = "Location: ../../src/" . $sender; // calling script

// one of these is empty, one contains information about an item
$rm_info = $_SESSION['rm_info'];
$dispersion_info = $_SESSION['dispersion_info'];

// getPassedArray(): Void -> Array
// Returns which of {$rm_info, $dispersion_info} is nonempty
function getPassedArray()
{
    global $rm_info, $dispersion_info;

    if (!empty($rm_info)) {
        return $rm_info;
    } else if (!empty($dispersion_info)) {
        return $dispersion_info;
    } else {
        returnToSender('', "Unrecognized item type (attempted item info update)", '', array(), array());
    }
}

$passed_array = getPassedArray();
$item_uid = $passed_array['uid'];

// returnToSender: String String String Array Array -> Void
// Sets session variables and returns to calling script. If
// database connection is active/open, closes it. Returns given status, error message,
// success message, rm info array, dispersion info array.
function returnToSender($status, $errMsg, $successMsg, $rm_info, $dispersion_info)
{
    // gets global reference
    global $destination, $con;
    // closes database conn. if conn. has been attempted and succeeded
    isset($con) and $con and $con->close();

    $_SESSION = [];
    $_SESSION['status'] = $status;
    $_SESSION['err_msg'] = $errMsg;
    $_SESSION['success_msg'] = $successMsg;
    $_SESSION['rm_info'] = $rm_info;
    $_SESSION['dispersion_info'] = $dispersion_info;

    // returns to calling script
    header($destination);
    exit();
}

// connectToDB(): Void -> Void
// Attempts to establish connection to databse
function connectToDB()
{
    global $rm_info, $dispersion_info;

    // Variables required for MySQL connection
    $server = "208.109.166.118";
    $username = 'danielwilczak';
    $password = 'Dmw0234567';
    $database = "LEI_Inventory";

    // Attempts connection to database
    global $con;
    $con = mysqli_connect($server, $username, $password, $database);

    // Returns with an error message if error occurs
    if (mysqli_connect_errno()) {
        returnToSender('info', 'Connection to database failed.<br>Error: ' . $con->error, '', $rm_info, $dispersion_info);
    }
}

// queryDatabase(): String -> Void
// Attempts to query the database with the given SQL query
function queryDatabase($sql)
{
    global $con, $rm_info, $dispersion_info, $item_uid;

    $result = $con->query($sql);

    if (!$result) {
        returnToSender('info', 'Database query failed: <br> uid:' . $item_uid . '<br>query: ' . $sql, '', $rm_info, $dispersion_info);
    }

    if (mysqli_connect_errno()) {
        returnToSender('info', 'Database query failed: <br> uid:' . $item_uid . '<br>query: ' . $sql . '<br>Error: ' . $con->error, '', $rm_info, $dispersion_info);
    }
}

// composeSuccessMsg(): Array -> String
// Returns a success message indicating successful transfer of item from
// live inventory to ARCHIVE database
function composeSuccessMessage($passed_array)
{
    global $rm_info, $dispersion_info;

    if (!empty($rm_info)) {
        return 'Successfully removed:<br>Name: ' . $passed_array['name'] . "<br>UID: " . $passed_array['uid'] . "R" . "<br>from the inventory.";
    } else if (!empty($dispersion_info)) {
        return 'Successfully removed:<br>Name: ' . $passed_array['name'] . "<br>UID: " . $passed_array['uid'] . "D" . "<br>from the inventory.";
    } else {
        return 'Successfully removed:<br>Name: ' . $passed_array['name'] . "<br>UID: " . $passed_array['uid'] . "<br>from the inventory.";
    }
}

// attempts to connect to database
connectToDB();

// Builds and submits query based on item type
if (!empty($rm_info)) {
    $insert_sql = "INSERT INTO 29_RAW_INVENTORY_ARCHIVE SELECT * FROM 29_RAW_INVENTORY" . " WHERE uid=" . $item_uid . ";";
    $delete_sql = "DELETE FROM 29_RAW_INVENTORY" . " WHERE uid=" . $item_uid . ";";

    queryDatabase($insert_sql);
    queryDatabase($delete_sql);

    // We know the query was successful
    returnToSender('success', '', composeSuccessMessage($passed_array), $rm_info, $dispersion_info);
} else if (!empty($dispersion_info)) {
    $insert_sql = "INSERT INTO 29_Dispersion_Inventory_ARCHIVE SELECT * FROM 29_Dispersion_Inventory" . " WHERE uid=" . $item_uid . ";";
    $delete_sql = "DELETE FROM 29_Dispersion_Inventory" . " WHERE uid=" . $item_uid . ";";

    queryDatabase($insert_sql);
    queryDatabase($delete_sql);

    // We know the query was successful
    returnToSender('success', '', composeSuccessMessage($passed_array), $rm_info, $dispersion_info);
}
