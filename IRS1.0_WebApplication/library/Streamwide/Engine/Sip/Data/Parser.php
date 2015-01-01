<?php
/**
 *
 * $Rev: 1982 $
 * $LastChangedDate: 2009-09-28 19:09:31 +0800 (Mon, 28 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @author Adrian SIMINICEANU <asiminiceanu@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Sip
 * @version 1.0
 *
 */

class Streamwide_Engine_Sip_Data_Parser
{

    /**
     * Sip headers
     */
    const SIP_HISTORY_INFO = 'sip_history-info';
    const SIP_DIVERSION = 'sip_diversion';
    const SIP_REMOTE_PARTY_ID = 'sip_remote-party-id';
    const SIP_P_ASSERTED_IDENTITY = 'sip_p-asserted-identity';
    const SIP_P_PREFERRED_IDENTITY = 'sip_p-preferred-identity';
    const SIP_TO = 'sip_to';
    const SIP_FROM = 'sip_from';

    /**
     * The sip header prefix
     */
    const SIP_PREFIX = 'sip_';

    /**
     * The list of sip headers to be parsed
     *
     * @var array
     */
    private $_sipHeaders = array();

    /**
     * Constructor
     *
     * @param array $sipHeaders
     */
    public function __construct(Array $sipHeaders = array())
    {
        $this->setSipHeaders($sipHeaders);
    }

    /**
     * Set the sip headers list
     *
     * @param array $sipHeaders
     * @param boolean $merge
     * @return void
     */
    public function setSipHeaders(Array $sipHeaders = array(), $merge = false)
    {
        // clean up the array and keep only the keys that start with the prefix
        foreach ($sipHeaders as $sipHeader => $sipHeaderValue) {
            if (self::SIP_PREFIX != substr($sipHeader, 0, strlen(self::SIP_PREFIX))) {
                unset($sipHeaders[$sipHeader]);
            }
        }

        if (false === $merge) {
            $this->_sipHeaders = $sipHeaders;
        } else {
            $this->_sipHeaders = array_merge($this->_sipHeaders, $sipHeaders);
        }
    }

    /**
     * Extract a phone number (or username) from a sip header of the form : "xyz" <proto:num[@host]>;param=value;...
     *
     * @param string $sipHeader The header from which the information should be extracted
     * @param integer $offset The offset value in the header ($offset >= 0 left to right; $offset < 0 right to left)
     * @return string|boolean false
     */
    public function extractPhoneNumber($sipHeader, $offset = 0)
    {
        // if the header is not in the sip headers list
        // will return false
        if (!array_key_exists($sipHeader, $this->_sipHeaders)) {
            return false;
        }

        // get the $sipHeader value
        switch ($sipHeader) {
            case self::SIP_DIVERSION:
                $sipHeaderValue = $this->_getOffsetValue($sipHeader, $offset, true);
                break;

            default:
                $sipHeaderValue = $this->_getOffsetValue($sipHeader, $offset);
                break;
        }

        // first keep the part between <>
        $brackets = explode('>', $sipHeaderValue);
        $brackets = explode('<', $brackets[0]);

        if (count($brackets) < 2) {
            $uri = $brackets[0];
        } else {
            $uri = $brackets[1];
        }

        // now $uri contains the proto:num[@host] part
        $sipParts = explode(':', $uri);

        // remove the part before :
        if (count($sipParts) < 2) {
            $sipPart = $sipParts[0];
        } else {
            $sipPart = $sipParts[1];
        }

        // remove the part after @
        $numParts = explode('@', $sipPart);
        $shortParts = explode(';', $numParts[0]);

        return $shortParts[0];
    }

    /**
     * Extract the redirect reason for a certain sip header
     *
     * @param string $sipHeader The header for which the information should be extracted
     * @param string $param The parameter to be extracted in some cases
     * @param integer $offset The offset value in the header ($offset >= 0 left to right; $offset < 0 right to left)
     * @return string|boolean false
     */
    public function extractRedirectReason($sipHeader, $param = null, $offset = 0)
    {
        // if the header is not in the sip headers list
        // will return false
        if (!array_key_exists($sipHeader, $this->_sipHeaders)) {
            return false;
        }

        // the reason is extracted differently for each sip header
        switch ($sipHeader) {
            case self::SIP_HISTORY_INFO:
                $reason = $this->_extractHistoryInfoReason($offset);
                break;

            case self::SIP_DIVERSION:
                $reason = $this->_extractDiversionReason($offset);
                break;

            case self::SIP_REMOTE_PARTY_ID:
            case self::SIP_TO:
                $reason = $this->extractParam('sip_reason', $param);
                break;

            default:
                // the rest of the headers are not used for retrieving the redirect reason
                $reason = false;
                break;
        }

        return $reason;
    }

    /**
     * Extract a parameter value from a sip header of the form : "xyz" <proto:num[@host]>;param=value;...
     *
     * @param string $sipHeader The header from which the information should be extracted
     * @param string $which The parameter to be extracted
     * @param integer $offset The offset value in the header ($offset >= 0 left to right; $offset < 0 right to left)
     * @return string|boolean false
     */
    public function extractParam($sipHeader, $which, $offset = 0)
    {
        // if the header is not in the sip headers list
        // will return false
        if (!array_key_exists($sipHeader, $this->_sipHeaders)) {
            return false;
        }

        // get the $sipHeader value
        $sipHeaderValue = $this->_getOffsetValue($sipHeader, $offset);

        $params = explode(";", $sipHeaderValue);
        // here we eliminate the sip:xxx@yyy part
        array_shift($params);

        foreach ($params as $param) {
            $param = trim($param);
            $pair = explode('=', $param, 2);
            if ($pair[0] == $which) {
                return $pair[1];
            }
        }

        return false;
    }


    /**
     * Extract the redirect reason from History-Info.
     * Will return the oldest redirect reason.
     *
     * @param integer $offset The offset value in the header ($offset >= 0 left to right; $offset < 0 right to left)
     * @return string|boolean false
     */
    private function _extractHistoryInfoReason($offset)
    {
        // get the History-Info header value
        $historyInfoValue = $this->_getOffsetValue(self::SIP_HISTORY_INFO, $offset);

        // get the header lines
        $lines = explode(',', $historyInfoValue);

        // if nothing will be found the result is false
        $reason = false;

        foreach ($lines as $line) {
            $fields = explode(';', $line);

            foreach ($fields as $field) {
                $field = trim($field);
                if('cause=' == strtolower(substr($field, 0, 6))) {
                    $reason = substr($field, 6);
                    break(2);
                }
            }
        }

        return $reason;
    }

    /**
     * Extract the redirect reason from Diversion
     *
     * @param integer $offset The offset value in the header ($offset >= 0 left to right; $offset < 0 right to left)
     * @return string|boolean false
     */
    private function _extractDiversionReason($offset)
    {
        // get the History-Info header value
        $diversionValue = $this->_getOffsetValue(self::SIP_DIVERSION, $offset, true);

        // if nothing will be found the result is false
        $reason = false;

        $fields = explode(';', $diversionValue);
		foreach($fields as $field) {
			$field = trim($field);
			if ('reason=' == substr($field, 0, 7)) {
				$reason = substr($field, 7);
                break;
			}
		}

        return $reason;
    }

    /**
     * Get a certain offset value from the sip header
     *
     * @param string $sipHeader The sip header
     * @param integer $offset The offset of the value to be extracted
     * @param boolean $multipleInstances If the header can have multiple instances or not the separator varies
     * @return string
     */
    private function _getOffsetValue($sipHeader, $offset, $multipleInstances = false)
    {
        // get the header value
        $sipHeaderValue = $this->_sipHeaders[$sipHeader];

        // if the header has multiple instances then the values are separated by '\n'
        if ($multipleInstances) {
            $sipHeaderValue = strtr($sipHeaderValue, "\n", ',');
        }

        $sipHeaderValues = explode(',', $sipHeaderValue);

        // if the offset goes over the limit then the last value will be used
        $neededOffset = ($offset < 0) ? (count($sipHeaderValues) - 1 - abs($offset)) : $offset;

        // if the offset is negative use the first one
        if (!isset($sipHeaderValues[$neededOffset]) && $offset < 0) {
            $neededOffset = 0;
        }

        // if the offset goes over the upper limit use the last one
        if (!isset($sipHeaderValues[$neededOffset]) && $offset > 0) {
            $neededOffset = count($sipHeaderValues) - 1;
        }

        return $sipHeaderValues[$neededOffset];
    }
}

/* EOF */