<?php 
/**
 * PasswordProtector : An implementation of protected pages
 * 
 * USAGE:
 * Administrator sets a password in Theme Options > Protected Content. 
 * Then can assign pages to the secure template.
 * 
 * Users will be presented with a form asking for the password. If 
 * correctly supplied, it is stored as an MD5 hashed cookie valid 
 * for 24 hours. 
 * 
 * That time is configured in this class. Along with success/error 
 * flash messages for the users and the sign-in form HTML.
 * 
 * @see page-template-secure.php in the theme root
 */
class PasswordProtector {

    private $can_view_content = false;
    private $correct_password = false;
    public  $flash_message = [];

    public function __construct()
    {
        if( ! class_exists('ACF') ) {
            return;
        }
    }

    /**
     * Main logic for password protector
     * 
     * Handles authorization logic. Template output is done 
     * externally.
     */
    public function handle() {

        //Get password from ACF options
        $this->correct_password = get_field('protected_content_password', 'option');
    
        //Check if user has a valid cookie
        $this->can_view_content = $this->has_valid_cookie_auth();

        if($this->can_view_content) {
            $this->can_view_content = true;
            return true;
        }

        //Handle form input
        $this->handleForm();

    }

    private function handleForm()
    {
        //Nothing to handle
        if(!isset($_POST['content_password'])) {
            return false;
        }

        //Wrong password
        if(md5($_POST['content_password']) !== md5($this->correct_password)) { 
            $this->flash_message = ['Wrong password.', 'error'];
            return false;
        }

        //Correct password submitted
        $this->can_view_content = true;
        $this->flash_message = ['You are signed in.', 'success'];
        $hour_in_seconds = 3600;
        $day_in_seconds = 24 *  $hour_in_seconds;

        //Set cookie for 1 day
        setcookie('content_password', md5($_POST['content_password']), time() + $day_in_seconds);
    }

    public function has_valid_cookie_auth()
    {
        //If no cookie return
        if(!isset( $_COOKIE['content_password'])) {
            return false;
        }
        //Password is md5 hashed when saved to cookie
        if($_COOKIE['content_password'] == md5($this->correct_password)) {
            return true;
        }
    }

    public function can_view_content()
    {
        return $this->can_view_content;
    }

    public function output_form()
    {
        ob_start();?>
        <div class="protected-content-outer">
            <div class="protected-content">
                <div class="protected-content-inner">
                    <h2>Password Required</h2>

                    <form action="" method="POST">

                        <input type="text" name="content_password">

                        <input type="submit">

                    </form>
                </div>
            </div>
        </div>

        <?php  echo ob_get_clean();

    }
}

if( class_exists('ACF') ) {
    $ss_password_protector = new PasswordProtector;
    $ss_password_protector->handle(); 
    $ss_password_protector_can_view_content = $ss_password_protector->can_view_content();
}