<?php

/**
 * This is a model that represents the purchase of cards
 *
 * 
 * @author Richard
 */
class Purchase extends CI_Model
{
    
    // Constructor
    public function __construct()
    {
        parent::__construct();
        
        
    }
    
 
    //    <certificate>
    //        <token>102d6</token>
    //        <piece>11b-1</piece>
    //        <broker>A04</broker>
    //        <player>Richard</player>
    //        <datetime>1460484083</datetime>
    //    </certificate>
    function purchase($team, $token, $player) 
    {
        $report = '';
        

       //is the game status open?
        $this->gamestate->refresh();
        $code = $this->gamestate->get_code(); // 3 represents open
        if ($code == 3 ) 
        {
            
            
         
            if(!empty($team) && !empty($token) && !empty($player)) //verify parameters
            {
                
                $response = $this->curl->simple_post('http://botcards.jlparry.com/buy', array('team'=>$team,'token'=>$token,'player'=>$player));
                //$report = $response + '</br>'; 
                $xml = simplexml_load_string($response);

                //Card packs cost 10 peanuts.
                //get current # of peanuts for current player
                // update peanuts -10

                $peanuts = $this->players->get_peanuts($player);
                $new_peanuts = $peanuts - 10; // cost of pack is 10 nuts
                if ($new_peanuts >= 0)
                {
                $this->players->update_peanuts($player, $new_peanuts);
                    foreach ($xml->certificate as $certificate)
                    {
                        $timestamp = date(DATE_ATOM, (int)$certificate->datetime); //convert unix time to mysql compatable
                        $data = array(
                        'token' => (string)$certificate->token,
                        'piece' => (string)$certificate->piece,
                        'broker' => (string)$certificate->broker,
                        'player' => (string)$certificate->player,
                        'datetime' => $timestamp
                         );
                        $this->db->insert('collections', $data);// insert into database
                     


                    }

                    return $report . 'Cards Successfully Purchased!';
                }
                else 
                {
                    return $report . 'Not enough peanuts!';
                }
            }
            else 
            {
                 //team, token or player variable null or empty
                if(empty($player))
                {
                    return 'You must login!';
                }
                else 
                {
                 return $report . "team or token not set, or the agent may not be registered.";
                }
            }
        }
        else 
        {
         return $report . "Server is not open, try again later...";
            
            
        }
 
    }
    
}
