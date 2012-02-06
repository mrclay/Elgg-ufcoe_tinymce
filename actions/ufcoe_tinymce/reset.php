<?php

$plugin = elgg_get_plugin_from_id('ufcoe_tinymce');
/* @var ElggPlugin $plugin */

//$plugin->unsetAllSettings(); currently broken
foreach (array_keys($plugin->getAllSettings()) as $key) {
    $plugin->unsetSetting($key);
}

system_message('All UFCOE TinyMCE settings have been reset');
forward(REFERER);