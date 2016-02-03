<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 2/2/16
 * Time: 11:01 PM
 */

namespace App;


class JiraPayload
{

    protected $url = 'https://smscvt.atlassian.net/';

    protected $payload = [];

    protected $users = [
        'alfrednutile@gmail.com',
        'hoshinoas@gmail.com',
        'cavanaghacea@gmail.com',
        'tgerman1029@yahoo.com',
        'bao@appnovation.com',
        'rob.sherali@gmail.com',
        'nathan.kirschbaum@gmail.com'
    ];

    public function getUserEmail()
    {
        if(empty($this->payload))
            return false;

        return $this->payload['user']['emailAddress'];
    }

    public function getLink()
    {
        if(empty($this->payload))
            return false;

        if(!isset($this->payload['issue']))
            return false;

        return $this->payload['issue']['fields']['summary'];
    }

    public function makeIssueUpdatedMessage()
    {
        $issue_title = $this->getSummary();

        return sprintf("Update -- Issue: %s Link: %s for %s Status: %s",
            $issue_title, $this->getUrlWithBrowseAndKey(), $this->getAssigneeEmail(), $this->getStatus());
    }

    public function getStatus()
    {
        if(empty($this->payload))
            return false;

        if(!isset($this->payload['issue']))
            return false;

        return $this->payload['issue']['fields']['status']["name"];
    }

    public function getSummary()
    {
        if(empty($this->payload))
            return false;

        if(!isset($this->payload['issue']))
            return false;

        return $this->payload['issue']['fields']['summary'];
    }

    public function getAssigneeEmail()
    {
        if(empty($this->payload))
            return false;

        if(!isset($this->payload['issue']))
            return false;

        return $this->payload['issue']['fields']['assignee']['emailAddress'];
    }

    public function getCreatorEmail()
    {
        if(empty($this->payload))
            return false;

        return $this->payload['user']['emailAddress'];
    }

    public function getReporterEmail()
    {
        if(empty($this->payload))
            return false;

        if(!isset($this->payload['issue']))
            return false;

        return $this->payload['issue']['fields']['reporter']['emailAddress'];
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    public function userOnTeam($email)
    {
        return in_array($email, $this->getUsers());
    }

    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    private function getUrlWithBrowseAndKey()
    {
        return $this->getUrl() . 'browse/' .$this->payload['issue']['key'];
    }

}