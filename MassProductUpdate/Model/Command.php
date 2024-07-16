<?php
namespace Theshreyas\MassProductUpdate\Model;

class Command
{
    protected $_type       = '';
    protected $_info       = [];
    protected $_fieldLabel = '';
    protected $_errors     = [];
    
    public function getCreationData()
    {
        if (isset($this->_info)) {
            return $this->_info;
        } else {
            return false;
        }
    }

    /**
     * Gets list of not critical errors after the command execution
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }
}
