<?php

/**
 * Provides meta-data about the plugin.
 *
 * @package     local_message
 * @author      2022 Karl Thibaudeau <{author_link}>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use local_message\manager;

class local_message_external extends external_api{

    /**
     * Class constructor.
     */
   
public static function delete_message_parameters(){
    return new  external_function_parameters(
        ['message_id' => new external_value(PARAM_INT, 'id of message')]
    );
}

public static function delete_message_returns(){
    return new external_value(PARAM_BOOL,'True is message was succcessfullly deleted');
}

public static function delete_message($message_id): string{
    $params = self::validate_parameters(self::delete_message_parameters(), array('message_id'=>$message_id));
    $manager = new manager();
    return $manager->Delete($message_id);


}

}