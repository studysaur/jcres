<?php #
/* This script:
    *- defines constants and settings
    *- dictates how errors are handled
    *- defines useful functions
    */
    
//This site is being created for the Jackson County Sheriff Reserves


//**************************************************************  //
//**********************SETTINGS********************************//

//Flag variables for the site
    define('LIVE', FALSE);
    
    // Admin contact
    define('EMAIL', 'dino@sellars.org');
    
    // site URL (Base for all redirecttions):
    define ('BASE_URL', 'http;;jcres.us/');
    
    // Location of the MySQL connection script:

    
    // Adjust the time xone for php 5.1 and greater:
    date_default_timezone_set('US/Central');
    




//*****************************************************************//
//***********************  ERROR MANAGEMENT ***********************//

// Create the error handler;
    function my_error_handler ($e_number, $e_message, $e_file, $e_vars) {
    
    // Build the error message;
    $message = "An error occurred in script '$e_file' on line '$e_line' $e_message\n";
    
    // Add the date and time:
    $message .= "Date/Time: " . date('n-j-Y H:i:s') . \n;
    
    if (!LIVE) { // Development (print the error0.
        
        // Show the error message:
        echo '<div class="error">' . nl2blr($message);
        
        // Add the variable and a backtrace ;
        echo '<pre>' . print_r ($e_vars, 1) . "\n";
        debug_print_bactrace();
        echo '</pre></div>';
        
    } else { // don't show the error:
        
        // Send an email to the admin:
        $body = $message . "\n" . print_r($e_vars, 1);
        mail(EMAIL, 'Site Error!', $body, 'From: email@jcres.us');
        
        // Only print an error message if the error isn't a notice;
        if ($e_number != E_NOTICE) {
                echo '<div class="error">A system error occurred.  We apologize for the inconvnience.</div><br />';
            }
        } // End of !LIVE IF.
        
    } // End of my_error_handler() definition
    
    // Use my error handler:
    set_error_handler('my_error_handler');
    
    // ********************** ERROR MANAGEMENT *****************************//
    // *********************************************************************//