<?php #Script login_funcions.inc.php 
// this page defines two functions user by the login/logout process

/* This funtion determines an absolute URL and redirects the user there
    * The function takes one argument: the page to be didirected to
    * The arbument defaults to index.php 
    */
function redirect_user($page = 'index.php'){

    //Start defining the URL
    // URL is http:// plus the current directroy:
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    
    // Remove and trailing slashes
    $url =  rtrim($url, '/\\');
    
    // add the page
    $url .='/' . $page;
    
    // Redirect the user
    header("Location: $url");
    exit(); //Quit the script
    
}  // End of redirect_user(); function.


/* This function validates the form data the user_id and password
    * if both are present, the database is queried 
    * The function requires a database conncetion
    * The function returns an array of information, including;
    * - a TRUE/FALSE variable indication success
    * - an array of either errors or the database result
    */
function check_login($dbc, $user_id = '', $pass = '') {
    
    $errors = array(); //Initialize error array
    
    //Validate user_id
    if (empty($user_id)) {
        $errors[] = 'You forgot the enter your user id';
    } else { 
        $u= mysqli_real_escape_string($dbc, trim($user_id));
    }
    
    // Validate the password
    if (empty($pass)) {
        $errors[] = 'You for to enter your password';
    } else {
        $p = mysqli_real_escape_string($dbc, trim($pass));
    }
    
    if (empty($errors)) { // If everything is ok
    
        // Retrive the user id and the status for that user
        $q = "SELECT user_id, id, status FROM users WHERE user_id = '$u' AND password = SHA1('$p')";
        $r = db_query('$q');
        // run the query
        
        // Check the result:
        if (mysqli_num_rows($r) == 1) {

            // Fetch the record
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            // Retrun tru and the record;
            return(true, $row);
            
        } else { // not a match
            $errors[] = 'The User_id and password do not match';
        } // end else
    } // end of if empty
     
     
     // Return false  and the errors
     return array(false, $errors);
     
} *// End of check_login function