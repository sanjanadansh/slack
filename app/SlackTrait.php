<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 2/2/16
 * Time: 11:25 PM
 */

namespace App;


trait SlackTrait
{
    public $message_type = 'in_channel';

    public function seeIfEphemeral($search)
    {
        if($pos = strpos($search, 'ephemeral'))
        {
            $search = str_replace('ephemeral', '', $search);
            $this->message_type = 'ephemeral';
        }


        return $search;
    }

    public function getMessageType()
    {
        return $this->message_type;
    }

}