<?php
/**
 * Load a partial and pass variables into it
 *
 * e.g. echo td_view('partials/link', ['href'=> 'example.com', 'linktext' => 'Visit Example.com']);
 *
 * @param string $fileName  Name of the partial without .php appended
 * @param array  $variables Variables to make available in the partial
 *
 * @return string HTML
 */
function get_partial($fileName, $variables = array())
{
    foreach ($variables as $key => $value) {
        ${$key} = $value;
    }
    ob_start();
    include get_stylesheet_directory() . '/' .$fileName . '.php';
    return ob_get_clean();
}
/**
 * Shorthand to echo a partial instead of returning it 
 */
function the_partial($fileName, $variables = array())
{
    echo get_partial($fileName, $variables = array());
}
