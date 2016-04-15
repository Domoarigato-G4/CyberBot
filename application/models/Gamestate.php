<?php

/**
 * This is a model that represents the current game state
 *
 * Usage: Load model, call refresh and then use accessors to get current state.
 * 
 * @author Chris
 */
class Gamestate extends CI_Model {
    
    protected $status = 0; //0 = status unknown/bad retrieval, 1 = status known/good retrieval
    protected $code; //status code from server
    protected $round; //round number from server
    protected $countdown; //time left in current round (from server)
    
    // Constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->library('curl');
    }

    // call this function to refresh the game state (get from server)
    public function refresh()
    {
        $string = $this->curl->simple_get('http://' . $this->config->item('bcc') . '/status');
        //$string = $this->curl->simple_get('http://botcards.jlparry.com/status');
        
        //retrieve and parse XML
        $xml = @simplexml_load_string($string);
        
        //check for a failure
        if($xml === FALSE)
        {
            $this->status = 0;
            return;
        }
        
        $this->code = (int)$xml->state;
        $this->round = (int)$xml->round;
        $this->countdown = (int)$xml->countdown;
        $this->status = 1;
    }
    
    //accessor for status good/known variable
    public function get_status()
    {        
        return $this->status;
    }
    
    //accessor for state code (code)
    public function get_code()
    {       
        return $this->code;
    }
    
    //accessor for state name (state)
    public function get_state()
    {        
        //derive the state name from the numerical code       
        //PHP has no native enums and constant arrays are version dependent
        //maybe this isn't the most elegant way but it's the safest
        switch($this->code)
        {
            case 0:
                $state = "closed";
                break;
            case 1:
                $state = "setup";
                break;
            case 2:
                $state = "ready";
                break;
            case 3:
                $state = "open";
                break;
            case 4:                
                $state = "over";
                break;
            default:
                $state = "unknown"; //this should not happen
                break;
        }
        
        return $state;
    }
    
    //accessor for round number
    public function get_round()
    {
        return $this->round;
    }
    
    //accessor for time left (countdown)
    public function get_countdown()
    {
        return $this->countdown;
    }

}
