<?php
/**
 * Provides an annoucement area based on an ACF options page input
 */
class AnnouncementArea
{
    private static $instance = null;
    private $message = null;

    private function __construct($message_field_name)
    {
        if( ! class_exists('ACF') ) {
            return;
        }
        
        $this->message = get_field($message_field_name, 'option');
        if($this->shouldDisplay()) {
            add_action('storefront_before_content', [$this, 'outputHtml'], 1); //Hook into header.php
        }
    }

    public static function getInstance($message_field_name = 'header_message')
    {
        if (self::$instance == null) {
            self::$instance = new AnnouncementArea($message_field_name);
        }
        return self::$instance;
    }

    /**
     * Check if message should be displayed
     */
    private function shouldDisplay()
    {
        //Return if no message set
        if(!$this->message) {
            return false;
        }

        return true;
    }

    /**
     * Wrap the message in HTML and return
     */
    private function getHtml()
    {
        ob_start(); 
        ?>
        <div class="header-message-wrapper">
            <div class="header-wrapper-content">
                <?php echo $this->message; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Output HTML message.
     */
    public function outputHtml()
    {
        if($this->shouldDisplay()) {
            echo $this->getHtml();
        }
    }
}

AnnouncementArea::getInstance('header_message');
