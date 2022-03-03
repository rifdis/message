<?php
use FFI\Exception;

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


class MessageManager
{
    const TABLE = 'local_message';
    protected $id;
    protected $message_text;
    protected $message_type;


    public function __construct($id = NULL, $message_text = NULL, $message_type = NULL)
    {
        if (!empty($id)) {
            $this->id = $id;
        }
        $this->message_text = $message_text;
        $this->message_type = $message_type;
    }

    public function Create($message_text, $message_type)
    {
        global $DB;
        $result = NULL;
        $message = new stdClass();
        $message->message_text = $message_text;
         $message->message_type = $message_type;
        
        try {
            $result = $DB->insert_record($this::TABLE, $message);
        }
        catch (Exception $e) {
            return false;
        }
        return $result;
    }

    public function Delete($id)
    {
        global $DB;
        $result = NULL;
        try {
            $result = $DB->delete_records($this::TABLE, ['id' => $id]);
        }
        catch (Exception $e) {
            return false;
        }
        return $result;
    }

    public function Update($id, $message_text = NULL, $message_type = NULL)
    {
        global $DB;
        $result = NULL;
        $this->id = $id;
        $this->message_type = $message_type;
        $this->message_text = $message_text;
        $this->message_type = $message_type;
        try {
            $result = $DB->update_record($this::TABLE, $this);
        }
        catch (Exception $e) {
            return false;
        }
        return $result;
    }

    public function GetRecord($id)
    {
        global $DB;
        $result = NULL;
        try {
            $result = $DB->get_record($this::TABLE, ['id' => $id]);
        }
        catch (Exception $e) {
            return false;
        }
        return $result;
    }
    public function GetRecords($params = [])
    {
        global $DB;
        $result = NULL;
        try {
            $result = $DB->get_records($this::TABLE, $params);
        }
        catch (Exception $e) {
            return false;
        }
        return $result;
    }

    public function DisplayMessagesForUsers()
    {
        global $DB, $USER;
        $sql = "SELECT lm.id, lm.message_text, lm.message_type FROM {local_message} lm
            left outer join {local_message_read} lmr ON lm.id = lmr.message_id
            WHERE lmr.user_id <> :userid OR lmr.user_id IS NULL";

        $params = [
            'userid' => $USER->id,
        ];
        try {
            $messages = $DB->get_records_sql($sql, $params);

            foreach ($messages as $message) {
                $message_type = null;
                switch ($message->message_type) {
                   case '0':
                      $message_type = \core\output\notification::NOTIFY_WARNING;
                      break;
                   case '1':
                      $message_type = \core\output\notification::NOTIFY_SUCCESS;
                      break;
                   case '2':
                      $message_type = \core\output\notification::NOTIFY_ERROR;
                      break;
                   case '3':
                      $message_type = \core\output\notification::NOTIFY_INFO;
                      break;
                }
                if($message->id)
                \core\notification::add($message->message_text, $message_type);
          
                $readrecord = new stdClass();
                $readrecord->message_id = $message->id;
                $readrecord->user_id = $USER->id;
                $readrecord->time_read = time();
                $DB->insert_record('local_message_read', $readrecord);
          
             }
        }
        catch (Exception $e) {
            return false;
        }

        return $messages;
    }


}
