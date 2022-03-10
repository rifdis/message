<?php

if($hassiteconfig){

    $ADMIN->add('localplugins',new admin_category('local_message_category',get_string('pluginname','local_message')));
$settings = new admin_settingpage('local_message',get_string('pluginname','local_message'));
$ADMIN->add('local_message_category',$settings);

$settings->add(new admin_setting_configcheckbox('local_message/enabled','Enabled','Info about this setting', true));

$ADMIN->add('local_message_category', new admin_externalpage('local_message_manage','Message',$CFG->wwwroot.'/local/message/manage.php'));
}

