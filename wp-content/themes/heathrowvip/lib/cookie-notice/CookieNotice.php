<?php
/**
 * Adds a cookie notice to the site.
 */
class CookieNotice
{
    private static $instance = null;
    
    public function __construct()
    {
        add_action('wp_footer', [$this, 'outputHTML'], 9999);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CookieNotice();
        }
    
        return self::$instance;
    }

    /**
     * Output the cookie notice HTML
     */
    public function outputHTML()
    {
        ob_start();

        include_once(__DIR__.'/cookie-notice-content.php');

        echo ob_get_clean();
    }

    /**
     * Checks if a cookie is enabled by the user
     */
    public static function shouldLoadCookie(string $cookie_name) : bool
    {
        if (!isset($_COOKIE['cookie_options'])) {
            return false;
        }

        $cookie_option = $_COOKIE['cookie_options'];

        $cookie_option = preg_replace('/\\\\/', '', $cookie_option);

        $cookie_option = json_decode($cookie_option);
        
        if ($cookie_option->$cookie_name == 1) {
            return true;
        }

        return false;
    }

    /**
     * Example usage:
     * $cookieNotice = CookieNotice::getInstance();
     * if ($cookieNotice::shouldLoadPerformaceCookies()) {
     *     //Enable performance cookies
     * }
     */
    public static function shouldLoadPerformaceCookies()
    {
        return self::shouldLoadCookie('performance');
    }

    public static function shouldLoadFunctionalCookies()
    {
        return self::shouldLoadCookie('functional');
    }

    public static function shouldLoadTargetingCookies()
    {
        return self::shouldLoadCookie('targeting');
    }
}

CookieNotice::getInstance();
