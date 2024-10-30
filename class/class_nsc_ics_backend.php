<?php

class nsc_ics_backendsettings extends de_nikelschubert_nsc_ics
{
    private $settings;
    private $prefix;

    public function __construct()
    {
        $this->settings = $this->return_plugin_settings_without_db_settings();
        $this->prefix = $this->settings->plugin_prefix;
    }

    public function nsc_ics_executeWPactions()
    {
        add_action('admin_init', array($this, 'nsc_ics_register_settings'));
        add_action('admin_menu', array($this, 'nsc_ics_admin_menu'));

    }

    public function nsc_ics_createAdminPage()
    {
        $objSettings = $this->settings;
        require NSC_ics_PLUGINPATH . "admin/tpl/admin.php";
    }

    public function nsc_ics_admin_menu()
    {
        add_options_page($this->settings->plugin_name, $this->settings->plugin_name, "manage_options", $this->settings->plugin_slug, array($this, "nsc_ics_createAdminPage"));
    }

    public function nsc_ics_register_settings()
    {
        //settings werden mit db values angereichert
        $this->settings = $this->return_plugin_settings();
        $count_tab = -1;
        foreach ($this->settings->setting_page_fields->tabs as $tab) {
            $count_field = -1;
            $count_tab++;
            foreach ($tab->tabfields as $field) {
                $count_field++;
                $functionForValidation = "nsc_ics_validate_input";
                if ($field->extra_validation_name != false) {
                    $functionForValidation = $field->extra_validation_name;
                }
                if ($field->save_in_db === true && current_user_can("manage_options") === true) {
                    register_setting($this->settings->plugin_slug . $tab->tab_slug, $this->prefix . $field->field_slug, array($this, $functionForValidation));
                }

            }
        }
    }

    public function nsc_ics_validate_input($input)
    {
        return $this->sanitize_input($input);
    }

    private function sanitize_input($input)
    {
        $cleandValue = strip_tags(stripslashes($input));
        return sanitize_text_field($cleandValue);
    }

    public function nsc_ics_add_settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=' . $this->settings->plugin_slug . '">' . __('Settings') . '</a>';
        array_push($links, $settings_link);
        return $links;
    }

    public function deleteOptions()
    {
        if (current_user_can("manage_options") === false) {
            return false;
        }

        foreach ($this->settings->setting_page_fields->tabs as $tab) {
            foreach ($tab->tabfields as $field) {
                delete_option($this->settings->plugin_prefix . $field->field_slug);
            }
        }

    }

}
