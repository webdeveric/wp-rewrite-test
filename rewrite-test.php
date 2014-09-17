<?php
/*
Plugin Name: Rewrite Test
*/

class RewriteTest
{
    public function __construct() {
        add_filter('query_vars', array(&$this, 'add_query_vars'), 1, 1);

        add_action('parse_request', array(&$this, 'parse_request'), 1, 1);

        register_activation_hook(__FILE__, array(&$this, 'activate'));
        register_deactivation_hook(__FILE__, array(&$this, 'deactivate'));
    }

    public function add_query_vars($vars)
    {
        $vars[] = 'wde';
        return $vars;
    }

    public function add_rewrite_rules()
    {
        add_rewrite_rule(
            'wde/?$', 
            'index.php?wde=1',
            'top'
        );
    }

    public function parse_request($wp)
    {
        if (array_key_exists('wde', $wp->query_vars) && $wp->query_vars['wde'] == '1' ) {
            wp_die('do something');
        }
    }

    public function activate()
    {
        $this->add_rewrite_rules();
        flush_rewrite_rules();
    }

    public function deactivate()
    {
        flush_rewrite_rules();
    }
}

new RewriteTest();
