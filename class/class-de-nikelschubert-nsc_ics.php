<?php

class de_nikelschubert_nsc_ics
{
    private $settingsFile;
    private $settings_as_object;
    private $settings_as_object_without_db;
    private $active_tab;

    protected function return_plugin_settings()
    {
        if (empty($this->settings_as_object)) {
            $this->settings_as_object = $this->return_plugin_settings_without_db_settings();
            $this->add_current_setting_values();
        }
        return $this->settings_as_object;
    }

    protected function return_plugin_settings_without_db_settings()
    {
        if (empty($this->settings_as_object_without_db)) {
            $this->settings_as_object_without_db = $this->set_settings_as_object();
            if (empty($this->settings_as_object_without_db)) {
                throw new Exception($this->settingsFile . " was not readable. Make sure it contains valid json.");
            }
        }
        return $this->settings_as_object_without_db;
    }

    protected function return_settings_field($searched_field_slug)
    {
        $this->return_plugin_settings();
        foreach ($this->settings_as_object->setting_page_fields->tabs as $tab) {
            $number_of_fields = count($tab->tabfields);
            for ($i = 0; $i < $number_of_fields; $i++) {
                if ($tab->tabfields[$i]->field_slug == $searched_field_slug) {
                    return $tab->tabfields[$i];
                }
            }
        }
    }

    private function set_settings_as_object()
    {
        $this->settingsFile = NSC_ics_PLUGINPATH . "/settings.json";
        $settings = file_get_contents($this->settingsFile);
        $settings = json_decode($settings);
        if (empty($settings)) {
            throw new Exception($this->settingsFile . " was not readable. Make sure it contains valid json.");
        }
        return $settings;
    }

    public function php_version_good($minVersion = '5.4.0')
    {
        if (version_compare(phpversion(), $minVersion, '>=')) {
            return true;
        } else {
            return false;
        }
    }

    private function get_active_tab()
    {
        $this->active_tab = "";
        if (isset($_GET["tab"])) {
            $this->active_tab = $_GET["tab"];
        } else {
            $this->active_tab = $this->settings_as_object->setting_page_fields->tabs[0]->tab_slug;
        }
    }

    // this fuctions gets the value saved in wordpress db using get_option
    // and adds it to the settings object in the pre_selected_value field.
    // if no value is set it sets the default value from settings file.
    private function add_current_setting_values()
    {
        $this->get_active_tab();
        $this->settings_as_object->setting_page_fields->active_tab_slug = $this->active_tab;
        $numper_of_tabs = count($this->settings_as_object->setting_page_fields->tabs);
        for ($t = 0; $t < $numper_of_tabs; $t++) {
            $number_of_fields_in_this_tab = count($this->settings_as_object->setting_page_fields->tabs[$t]->tabfields);
            if ($this->active_tab == $this->settings_as_object->setting_page_fields->tabs[$t]->tab_slug) {
                $this->settings_as_object->setting_page_fields->tabs[$t]->active = true;
                $this->settings_as_object->setting_page_fields->active_tab_index = $t;
            }
            for ($f = 0; $f < $number_of_fields_in_this_tab; $f++) {
                $option_slug = $this->settings_as_object->plugin_prefix . $this->settings_as_object->setting_page_fields->tabs[$t]->tabfields[$f]->field_slug;
                $default_value = $this->settings_as_object->setting_page_fields->tabs[$t]->tabfields[$f]->pre_selected_value;
                $wp_option_value = get_option($option_slug, $default_value);
                if ($wp_option_value == "") {
                    $wp_option_value = $default_value;
                }
                $this->settings_as_object->setting_page_fields->tabs[$t]->tabfields[$f]->pre_selected_value = $wp_option_value;
            }
        }
    }
}
