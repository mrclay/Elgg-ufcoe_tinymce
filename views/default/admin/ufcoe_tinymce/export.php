<?php

$plugin = elgg_get_plugin_from_id('ufcoe_tinymce');
/* @var ElggPlugin $plugin */

$json = json_encode($plugin->getAllSettings());

$back_link = elgg_view('output/url', array(
    'text' => '« back',
    'href' => 'admin/plugin_settings/ufcoe_tinymce',
    'is_trusted' => true,
));

echo "<p>$back_link</p>";

echo elgg_view('input/plaintext', array(
    'value' => $json,
    'id' => 'json_export',
    'readonly' => 'readonly',
    'style' => 'height:10em',
));

echo "<script>
jQuery(function ($) {
    $('#json_export').bind('focus click', function () { this.select(); })[0].select();
});
</script>";