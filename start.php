<?php

elgg_register_event_handler('init', 'system', 'ufcoe_tinymce_init');

function ufcoe_tinymce_init() {
    elgg_register_plugin_hook_handler('view', 'js/tinymce', 'ufcoe_tinymce_alter_views', 999);

    $actions = __DIR__ . '/actions/ufcoe_tinymce';
    elgg_register_action('ufcoe_tinymce/reset', "$actions/reset.php", 'admin');
    elgg_register_action('ufcoe_tinymce/import', "$actions/import.php", 'admin');
    elgg_register_action('ufcoe_tinymce/settings/save', "$actions/settings/save.php", 'admin');

    elgg_register_css('ufcoe_tinymce/admin', 'mod/ufcoe_tinymce/static/admin.css');
}

/**
 * @return array
 */
function _ufcoe_tinymce_string_options() {
    return array(
        'theme_advanced_buttons1', 'theme_advanced_buttons2', 'theme_advanced_buttons3',
        'plugins' //, 'extended_valid_elements'
    );
}

/**
 * @param string $hook
 * @param string $type
 * @param string $return
 * @param array $params
 * @return string
 */
function ufcoe_tinymce_alter_views($hook, $type, $return, $params) {
    switch ($type) {
        case 'js/tinymce':
            $names = _ufcoe_tinymce_string_options();
            $plugin = elgg_get_plugin_from_id('ufcoe_tinymce');
            /* @var ElggPlugin $plugin */
            $settings = $plugin->getAllSettings();
            $in_admin = elgg_in_context('admin');
            foreach ($names as $name) {
                // if we're in the admin panel, we need to check out all settings to report
                // them as defaults
                if ($in_admin || isset($settings["opt_$name"])) {
                    $pattern = '/(\\s' . $name . ' : )("[^"]*"),/';
                    $new_value = isset($settings["opt_$name"])
                        ? $settings["opt_$name"]
                        : null;
                    $callback = function ($m) use (&$original, $new_value) {
                        $original = json_decode($m[2]);
                        if (null === $new_value) {
                            $new_value = $original;
                        }
                        $m[2] = json_encode($new_value);
                        return $m[1] . $m[2] . ',';
                    };
                    $return = preg_replace_callback($pattern, $callback, $return);
                    if ($in_admin) {
                        $plugin->setVolatileData("orig_$name", $original);
                    }
                }
            }
            if (isset($settings['gecko_spellcheck'])) {
                $return = str_replace('tinyMCE.init({', 'tinyMCE.init({gecko_spellcheck:true,browser_spellcheck:true,', $return);
            }
        break;
    }
    return $return;
}