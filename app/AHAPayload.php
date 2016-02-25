<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 2/2/16
 * Time: 11:01 PM
 */

namespace App;


class AHAPayload
{

    protected $payload = [];

    protected $domain = 'det.aha.io';

    public function getEvent()
    {
        return $this->payload['event'];
    }

    public function getFeatureName()
    {
        return $this->payload['feature']['name'];
    }

    public function getFeatureURL()
    {
        return $this->payload['feature']['url'];
    }

    public function getWorkflowStatus()
    {
        return $this->payload['feature']['workflow_status']['name'];
    }

    public function getCreatedBy()
    {
        return $this->payload['feature']['created_by_user']['name'];
    }

    public function getAssignedTo()
    {
        return $this->payload['feature']['assigned_to_user']['name'];
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    public function makeSlackMessage()
    {



        $message = sprintf("Example Incoming from AHA: Created by %s, Type %s, Assigned to %s",
            $this->getCreatedBy(), $this->getEvent(), $this->getAssignedTo());

        return $message;
    }
}