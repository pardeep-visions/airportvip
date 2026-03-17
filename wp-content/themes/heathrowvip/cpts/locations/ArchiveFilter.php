<?php

class ArchiveFilterLocations
{

    protected $taxonomies;

    protected $post_type;

    public function __construct()
    {

        $this->taxonomies = [
            'location-categories' => [
                'get_param_name' => 'location-categories',
                'singular_label' => 'location-categories',
                'plural_label' => 'location-categories',
            ],

            'location-role' => [
                'get_param_name' => 'location-role',
                'singular_label' => 'location-role',
                'plural_label' => 'location-role',
            ],

        ]; // $taxonomy_name => (array) $options

        $this->post_type = 'locations';

        add_action('pre_get_posts', [$this, 'filter_locations_archive']);

        add_shortcode('locations_filter', [$this, 'output_filter_html']);
    }

    public function filter_locations_archive($query)
    {

        global $wpdb;

        if (is_admin()) {
            return;
        }

        //Only filter post type archive
        if (!$query->is_post_type_archive($this->post_type)) {
            return;
        }
        //Only filter the main query
        if (!$query->is_main_query()) {
            return;
        }

        //Hold query paramaters
        $taxonomy_query = array();
        $meta_query = array();

        //Check GET parameters for taxonomy filter(s)
        foreach ($this->taxonomies as $taxonomy_name => $options) {

            if (!isset($_GET[$options['get_param_name']]) || !$_GET[$options['get_param_name']]) {
                continue;
            }

            //Add to the taxonomy query
            $taxonomy_query[] = [
                'taxonomy' => $taxonomy_name,
                'field' => 'slug',
                'terms' => $_GET[$options['get_param_name']],
            ];
        }

        if (sizeof($taxonomy_query) > 1) {
            $taxonomy_query['operator'] = 'AND';
        }

        if ($taxonomy_query) {
            $query->set('tax_query', $taxonomy_query);
        }

        //Check get paramaters for cpd points filter
        if (isset($_GET['cpd-points'])) {
            $meta_query[] =
                [
                    'key' => 'cpd_points',
                    'type' => 'numeric',
                    'value' => intval($_GET['cpd-points']),
                    'compare' => '>='
                ];
        }

        //Check get paramaters for cpd points filter
        if (isset($_GET['price'])) {
            if ($_GET['price'] == 'free') {
                $meta_query[] =
                    [
                        'relation' => 'OR',
                        [
                            'key' => 'price',
                            'value' => 0,
                            'compare' => '='
                        ],
                        [
                            'key' => 'price',
                            'value' => '',
                            'compare' => '='
                        ],
                        [
                            'key' => 'price',
                            'compare' => 'NOT EXISTS'
                        ]
                    ];
            } elseif ($_GET['price'] == 'paid') {
                $meta_query[] =
                    [
                        'key' => 'price',
                        'value' => 0,
                        'compare' => '>'
                    ];
            }
        }

        if (sizeof($meta_query) > 1) {
            $meta_query['relation'] = 'AND';
        }

        if ($meta_query) {
            $query->set('meta_query', $meta_query);
        }
        // echo '<pre>';
        // var_dump($query->query_vars);
        // echo '</pre>';
    }

    public function output_filter_html()
    {

        ob_start();

        $filters = [];

        foreach ($this->taxonomies as $taxonomy_name => $options) {
            $filters[$taxonomy_name] = [
                'nicename' => $options['singular_label'],
                'singular_label' => $options['singular_label'],
                'plural_label' => $options['plural_label'],
                'terms' => get_terms(array(
                    'taxonomy' => $taxonomy_name,
                    'hide_empty' => false,
                ))
            ];
        }

        if (file_exists(get_stylesheet_directory() . '/cpts/locations/archive-filter.php')) {
            include(get_stylesheet_directory() . '/cpts/locations/archive-filter.php');
        }

        return ob_get_clean();
    }
}

$ss_archive_filter = new ArchiveFilterLocations;
