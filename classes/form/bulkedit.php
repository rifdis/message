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
//moodleform is defined in formslib.php

namespace local_message\form;
use moodleform;
use local_message\manager;

require_once("$CFG->libdir/formslib.php");

class bulkedit extends moodleform {
    //Add elements to form
    public function definition() {
        $plugin_name = 'local_message';
        global $CFG;
       
        $mform = $this->_form; // Don't forget the underscore! 

        // Display the list of messages with a checkbox
        $manager = new manager();
        $messages = $manager->GetRecords();

        foreach($messages as $message){
            $mform->addElement('advcheckbox', 'message_id' . $message->id, $message->message_text . 'Select');
        }

        $mform-> addElement('static', 'Choose Messages', 'Choose your messages');

        $choices = array();
        $choices[0] = \core\output\notification::NOTIFY_WARNING;
        $choices[1] = \core\output\notification::NOTIFY_SUCCESS;
        $choices[2] = \core\output\notification::NOTIFY_ERROR;
        $choices[3] = \core\output\notification::NOTIFY_INFO;
        $mform->addElement('select', 'message_type', 'Message Type',$choices);   
        $mform->setDefault('message_type',3);

        $mform->addElement('advcheckbox', 'delete_all', get_string('delete_all', $plugin_name));

        $this->add_action_buttons();
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}