<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Provides meta-data about the plugin.
 *
 * @package     local_message
 * @author      2022 Karl Thibaudeau <{author_link}>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__.'/../../config.php');
use local_message\manager;
$plugin_name = 'local_message';

require_login();
//require_admin();
$context = context_system::instance();
require_capability('local/message:managemessages', $context);
$PAGE->set_url($CFG->wwwroot.'/local/message/manage.php');

$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_title(get_string('pluginname', $plugin_name));
$PAGE->set_heading(get_string('pluginname', $plugin_name));
$PAGE->set_pagelayout('admin');
$PAGE->requires->js_call_amd('local_message/confirm');
$manager = new manager();
$messages = $manager->GetRecords();


echo $OUTPUT->header();

$templatecontext = (object)[
    'texttodisplay' => "List of all current messages",
    'messages' => array_values($messages),
    'editurl' => new moodle_url('/local/message/edit.php')

];

echo $OUTPUT->render_from_template('local_message/manage',$templatecontext);


echo $OUTPUT->footer();