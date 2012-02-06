<?php

$plugin = $vars['entity'];
/* @var ElggPlugin $plugin */

elgg_load_css('ufcoe_tinymce/admin');

// execute this view here to get the default values set in the plugin's volaliteData
elgg_view('js/tinymce', array());

$export_link = elgg_view('output/url', array(
    'text' => 'export',
    'href' => 'admin/ufcoe_tinymce/export',
));
$import_link = elgg_view('output/url', array(
    'text' => 'import',
    'href' => 'admin/ufcoe_tinymce/import',
));

echo "<h4>Preview of current settings | $export_link | $import_link</h4>";
echo elgg_view('input/longtext', array(
    'style' => 'height:3em',
    'value' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore...',
));

$names = _ufcoe_tinymce_string_options();

$settings = $plugin->getAllSettings();

$table = "<table class='ufcoe-tinymce'>";

foreach ($names as $name) {
    $table .= "<tr><th>" . str_replace('_', '_<br>', $name) . "</th>";

    $orig_value = $plugin->getVolatileData("orig_" . $name);
    if (isset($settings["opt_$name"])) {
        $setting_value = $settings["opt_$name"];
    } else {
        $setting_value = $orig_value;
    }

    $input = elgg_view('input/plaintext', array(
        'name' => "params[opt_$name]",
        'value' => preg_replace('/\\s*,\\s*/', ', ', $setting_value),
    ));
    $default = htmlspecialchars(preg_replace('/\\s*,\\s*/', ', ', $orig_value));

    $sub_table = "<table><tr><th>current</th><td>$input</td></tr>"
               . "<tr><th>default</th><td><div>$default</div></td></tr></table>";

    $table .= "<td>$sub_table</td></tr>";
}

$gecko_spellcheck = isset($settings['gecko_spellcheck'])
    ? (bool) $settings['gecko_spellcheck']
    : false;
$checkbox_options = array(
    'name' => 'gecko_spellcheck',
    'default' => false,
    'value' => '1',
);
if ($gecko_spellcheck) {
    $checkbox_options['checked'] = 'checked';
}
$input = elgg_view('input/checkbox', $checkbox_options);
$table .= "<tr><th>gecko_<br>spellcheck</th><td>$input enable browser-based spellcheck if available</td></tr>";

$table .= "</table>";

echo "<h4>tinyMCE.init() options | resources:
    <a target='_blank' href='http://www.tinymce.com/wiki.php/Buttons/controls'>buttons</a>,
    <a target='_blank' href='http://fiddle.tinymce.com/baaaab'>fiddler</a>,
    <a target='_blank' href='http://www.tinymce.com/wiki.php/Configuration'>other</a>
";
echo elgg_view('output/confirmlink', array(
    'text' => 'Reset all to defaults',
    'href' => elgg_add_action_tokens_to_url('action/ufcoe_tinymce/reset'),
    'class' => 'elgg-button elgg-button-action ufcoe-tinymce-reset',
)) ."</h4>";
echo $table;


