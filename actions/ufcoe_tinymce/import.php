<?php

$plugin = elgg_get_plugin_from_id('ufcoe_tinymce');
/* @var ElggPlugin $plugin */

$json = get_input('json');

$settings = json_decode($json, true);

if (! is_array($settings)) {
    register_error('JSON decoding failed');
    forward(REFERER);
}

foreach (_ufcoe_tinymce_string_options() as $opt) {
    $opt_name = "opt_$opt";
    if (isset($settings[$opt_name]) && is_string($settings[$opt_name])) {
        $plugin->set($opt_name, $settings[$opt_name]);
    }
}
if (isset($settings['gecko_spellcheck'])) {
    $plugin->set('gecko_spellcheck', '1');
} else {
    $plugin->unsetSetting('gecko_spellcheck');
}

system_message('Imported settings');
forward('admin/plugin_settings/ufcoe_tinymce');