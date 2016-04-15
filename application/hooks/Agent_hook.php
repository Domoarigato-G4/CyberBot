<?php

/**
 * Hook for agent autorun
 *
 * @author Chris
 */
class Agent_hook
{
    //because we have no reference to CI at this point
    var $ci;

    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('agent');
    }

    //execute agent refresh
    function autorun()
    {
        $this->ci->agent->refresh();
    }
}
