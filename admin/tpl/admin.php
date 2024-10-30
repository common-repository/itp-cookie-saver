<div class="wrap">

<h1>ITP Cookie Saver - rescues cookies</h1>

<h2 class="nav-tab-wrapper">
<?php
//tabs are created
foreach ($objSettings->setting_page_fields->tabs as $tab) {
    $activeTab = "";
    if ($tab->active === true) {
        $activeTab = 'nav-tab-active';
    }
    echo '<a href="?page=' . $objSettings->plugin_slug . '&tab=' . $tab->tab_slug . '" class="nav-tab ' . $activeTab . '" >' . $tab->tabname . '</a>';
}
$active_tab_index = $objSettings->setting_page_fields->active_tab_index;
$fe_fields = new nsc_bar_fe_wp_formfields;
?>
</h2>
<form action="options.php" method="post">
<?php
settings_fields($objSettings->plugin_slug . $objSettings->setting_page_fields->tabs[$active_tab_index]->tab_slug);
do_settings_sections($objSettings->plugin_slug);
?>

<?php submit_button();?>

<table class="form-table">
<?php foreach ($objSettings->setting_page_fields->tabs[$active_tab_index]->tabfields as $field_configs) {?>
 <tr id="tr_<?php echo $field_configs->field_slug ?>">
  <th scope="row">
    <?php echo $field_configs->name ?>
  </th>
  <td>
    <fieldset>
     <label>
      <?php echo $fe_fields->return_form_field($field_configs, $objSettings->plugin_prefix); ?>
     </label>
     <p class="description"><?php echo $field_configs->helpertext ?></p>
    </fieldset>
  </td>
 </tr>
<?php }?>
</table>
</form>
<?php

class nsc_bar_fe_wp_formfields
{
    private $field;
    private $prefix;

    function return_form_field($field, $prefix)
    {
        $this->field = $field;
        $this->prefix = $prefix;
        switch ($this->field->type) {
            case "checkbox":
                return $this->create_checkbox();
                break;
            case "textarea":
                return $this->create_textarea();
                break;
            case "text":
                return $this->create_text();
                break;
            case "select":
                return $this->create_select();
                break;
            case "radio":
                return $this->create_radio();
                break;
            default:
                return $this->field->pre_selected_value;
                break;
        }
    }

    function create_checkbox()
    {
        return '<input id="ff_' . $this->prefix . $this->field->field_slug . '" type="checkbox" name="' . $this->prefix . $this->field->field_slug . '" id="' . $this->prefix . $this->field->field_slug . '" value="1" ' . checked(1, $this->field->pre_selected_value, false) . '>';
    }

    function create_textarea()
    {
        return '<textarea id="ff_' . $this->prefix . $this->field->field_slug . '" cols="120"  id="' . $this->prefix . $this->field->field_slug . '" name="' . $this->prefix . $this->field->field_slug . '" rows="20" class="large-text code" type="textarea">' . $this->field->pre_selected_value . '</textarea>';
    }

    function create_text()
    {
        return '<input id="ff_' . $this->prefix . $this->field->field_slug . '" type="text"  id="' . $this->prefix . $this->field->field_slug . '" name="' . $this->prefix . $this->field->field_slug . '" size="30" maxlength="2000" value="' . $this->field->pre_selected_value . '">';
    }

    function create_select()
    {

        $html = '<select id="ff_' . $this->prefix . $this->field->field_slug . '"  name="' . $this->prefix . $this->field->field_slug . '" id="' . $this->prefix . $this->field->field_slug . '">';
        foreach ($this->field->selectable_values as $selectable_value) {
            $select = "";
            if ($selectable_value->value == $this->field->pre_selected_value) {$select = "selected";}
            $html .= '<option value="' . $selectable_value->value . '" ' . $select . '>' . $selectable_value->name . '</option>';
        }
        $html .= "</select>";
        return $html;
    }

    function create_radio()
    {
        $html = "";
        foreach ($this->field->selectable_values as $selectable_value) {
            $select = "";
            if ($selectable_value->value == $this->field->pre_selected_value) {$select = "checked";}
            $html .= '<input id="ff_' . $this->prefix . $this->field->field_slug . '"  type="radio" name="' . $this->prefix . $this->field->field_slug . '" value="' . $selectable_value->value . '" ' . $select . ' > ' . $selectable_value->name . ' ';
        }
        return $html;
    }

}

?>

