<?php

echo elgg_view('input/plaintext', array(
    'name' => 'json',
    'style' => 'height:10em',
));

$submit = elgg_view('input/submit', array(
    'value' => 'Import',
    'style' => 'margin-right:.6em',
));

$cancel = elgg_view('output/url', array(
    'text' => 'cancel',
    'href' => 'admin/plugin_settings/ufcoe_tinymce',
    'is_trusted' => true,
));

echo "<p>$submit $cancel</p>";