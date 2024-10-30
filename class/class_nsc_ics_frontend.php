<?php

class nsc_ics_frontend extends de_nikelschubert_nsc_ics
{
    public function nsc_ics_executeWordpressActions()
    {
        add_action('wp_enqueue_scripts', array($this, 'nsc_ics_add_before_unloadscript'));
    }

    public function nsc_ics_add_before_unloadscript()
    {
        wp_register_script('nsc_ics_cookiesaver', NSC_ics_PLUGINURL . '/frontend/js/nsc_ics_cookiesaver.js', array(), '1.0');
        wp_enqueue_script('nsc_ics_cookiesaver');
    }

}
