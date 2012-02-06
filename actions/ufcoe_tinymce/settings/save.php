<?php

$plugin = elgg_get_plugin_from_id('ufcoe_tinymce');
/* @var ElggPlugin $plugin */
$plugin_name = $plugin->getManifest()->getName();

if (get_input('gecko_spellcheck', '')) {
    $plugin->setSetting('gecko_spellcheck', '1');
} else {
    $plugin->unsetSetting('gecko_spellcheck');
}

$params = get_input('params');

foreach ($params as $k => $v) {
    if (0 === strpos($k, 'opt_')) {
        $v = preg_replace('/\\s+/', '', $v);
    }

    $result = $plugin->setSetting($k, $v);
    if (! $result) {
        register_error(elgg_echo('plugins:settings:save:fail', array($plugin_name)));
        forward(REFERER);
    }
}

system_message(elgg_echo('plugins:settings:save:ok', array($plugin_name)));
forward(REFERER);