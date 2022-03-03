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

defined('MOODLE_INTERNAL') || die();
use local_message\manager;

global $CFG;

require_once(__DIR__.'../../lib.php');

class local_message_manager_test extends advanced_testcase{

    public function test_create_message(){
        $this->resetAfterTest(); //must be put before all unit tests to rollback state after test completed
        $this->setUser(2); //admin user
        $manager = new manager();
        $messages = $manager->GetRecords();
        $this->assertEmpty($messages); //ensure that the messages table is empty
        $result = $manager->Create('Test data','1');
       $this->assertTrue($result); //Ensure that the function returns true
        $messages = $manager->GetRecords();
        $this->assertNotEmpty($messages); //ensure that the messages table is NOT  empty
        $this->assertCount(1,$messages); //Ensure there is only 1 message created in the test
        $message = array_pop($messages); // Return the last piece of the array
        $this->assertEquals('Test data',$message->message_text);
        $this->assertEquals('1',$message->message_type);

    }

    public function test_get_messages(){
        global $USER;
        $this->resetAfterTest();
        $manager = new manager();

        $type = 2;
     
        $manager->Create('Test message 1',$type);
        $manager->Create('Test message 2',$type);
        $manager->Create('Test message 3',$type);

        $messages = $manager->GetRecords();
        $this->assertCount(3, $messages);
        foreach($messages as $message) {
            $result = $manager->markMessageRead($message->id,'1');
            $this->assertTrue($result);
        }
        $read_messages = $manager->get_all_message_read();
        $this->assertCount(3, $read_messages);
        
        $this->setUser(2);
        $message_for_users = $manager->DisplayMessagesForUsers();
        $this->assertCount(3, $message_for_users);
        $message_for_users2 = $manager->DisplayMessagesForUsers();
        $this->assertCount(0, $message_for_users2);
    }
    
}