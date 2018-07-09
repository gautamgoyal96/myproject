<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList;

use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

class IpAddressContext extends InstanceContext {
    /**
     * Initialize the IpAddressContext
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param string $accountSid The account_sid
     * @param string $ipAccessControlListSid The ip_access_control_list_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList\IpAddressContext 
     */
    public function __construct(Version $version, $accountSid, $ipAccessControlListSid, $sid) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array(
            'accountSid' => $accountSid,
            'ipAccessControlListSid' => $ipAccessControlListSid,
            'sid' => $sid,
        );
        
        $this->uri = '/Accounts/' . $accountSid . '/SIP/IpAccessControlLists/' . $ipAccessControlListSid . '/IpAddresses/' . $sid . '.json';
    }

    /**
     * Fetch a IpAddressInstance
     * 
     * @return IpAddressInstance Fetched IpAddressInstance
     */
    public function fetch() {
        $params = Values::of(array());
        
        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );
        
        return new IpAddressInstance(
            $this->version,
            $payload,
            $this->solution['accountSid'],
            $this->solution['ipAccessControlListSid'],
            $this->solution['sid']
        );
    }

    /**
     * Update the IpAddressInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return IpAddressInstance Updated IpAddressInstance
     */
    public function update($options = array()) {
        $options = new Values($options);
        
        $data = Values::of(array(
            'IpAddress' => $options['ipAddress'],
            'FriendlyName' => $options['friendlyName'],
        ));
        
        $payload = $this->version->update(
            'POST',
            $this->uri,
            array(),
            $data
        );
        
        return new IpAddressInstance(
            $this->version,
            $payload,
            $this->solution['accountSid'],
            $this->solution['ipAccessControlListSid'],
            $this->solution['sid']
        );
    }

    /**
     * Deletes the IpAddressInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->version->delete('delete', $this->uri);
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.IpAddressContext ' . implode(' ', $context) . ']';
    }
}