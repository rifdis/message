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

 use local_message\manager;
 use local_message\form\bulkedit;
 
require_once(__DIR__.'/../../config.php');
require_login();
$context = context_system::instance();
require_capability('local/message:managemessages', $context);
$manager = new manager();
$plugin_name = 'local_message';
$PAGE->set_url($CFG->wwwroot.'/local/message/manage.php');
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_title(get_string('edit_title', $plugin_name));

$message_id = optional_param('message_id', NULL, PARAM_INT);
//Display form
$mform = new bulkedit();



if ($mform->is_cancelled()) {
    //Go back to manage page
    redirect($CFG->wwwroot . '/local/message/manage.php', 'You cancelled the message form');
    

} else if ($fromform = $mform->get_data()) {
  //In this case you process validated data. $mform->get_data() returns data posted in form.
 //Insert data into database table
    
  $message = $fromform->messages;

  if($fromform->delete_all == true){
      $manager->Delete($messages);
  }
  foreach($message as $message){

  }

    if($insert_data){
  //  redirect($CFG->wwwroot . '/local/message/manage.php','Message has been saved' . $fromform->message_text);
    }

}

echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();