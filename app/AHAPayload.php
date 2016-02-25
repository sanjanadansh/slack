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

    protected $type = 'feature';

    protected $payload = [];

    protected $domain = 'det.aha.io';

    public function getEvent()
    {
        return $this->payload['event'];
    }

    public function getFeatureName()
    {
        return $this->payload[$this->type]['name'];
    }

    public function getURL()
    {
        return $this->payload[$this->type]['url'];
    }

    public function getWorkflowStatus()
    {
        return $this->payload[$this->type]['workflow_status']['name'];
    }

    public function getCreatedBy()
    {
        return $this->payload[$this->type]['created_by_user']['name'];
    }

    public function getOwner()
    {
        return $this->payload[$this->type]['owner']['name'];
    }

    public function getAssignedTo()
    {
        return $this->payload[$this->type]['assigned_to_user']['name'];
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

        switch($this->getEvent()) {
            case "create_release":
                $this->setType('release');
                $message = sprintf("Example Incoming Release from AHA: Created by %s, URL %s, Owner to %s Status %s",
                    $this->getCreatedBy(), $this->getUrl(), $this->getAssignedTo(), $this->getWorkflowStatus());
                break;
            case "create_feature":
                $message = sprintf("Example Incoming Feature from AHA: Created by %s, URL %s, Assigned to %s Status %s",
                    $this->getCreatedBy(), $this->getUrl(), $this->getAssignedTo(), $this->getWorkflowStatus());
                break;
            default:
                $message = "Not sure the type just yet of this payload";
        }


        return $message;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}