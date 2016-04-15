<?php

/**
 * Controller for portfolio page.
 * 
 * controllers/Portfolio.php
 *
 * ------------------------------------------------------------------------
 */
class Portfolio extends Application {

    function __construct()
    {
            parent::__construct();
            $this->load->model('players');
            $this->load->model('collections');
            $this->load->model('transactions');
            $this->load->model('purchase');
            $this->load->model('gamestate');
            $this->load->model('agent');
            $this->load->helper('form');
            $this->load->library('session');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index()
    {   
        $this->render_page();
    }
    
    function render_page() 
    {
        $this->data['title'] = 'Player Portfolio';
        $this->data['pagebody'] = 'portfolio';
        $this->player_prep();      
        $this->create_holdings_pane();
        $this->create_activity_pane(); 
        if (!empty($this->session->flashdata('last_buy')))
        {
            $buy_message = $this->session->flashdata('last_buy');
            $this->data['buy_response'] = $buy_message;
        }
        else 
            {
            $this->data['buy_response'] = "";
            }
        $this->render();
    }

    function player_prep()
    {
         // get list of players
        $players_records = $this->players->all();
        
        //get player from GET, get player from session if it doesn't exist, default to first known player
        if($this->input->get('player'))
        {
            $this->player = $this->input->get('player');
			$this->data['name'] = $this->input->get('player');
        }
        else if($this->session->userdata('username'))
        {
            $this->player = $this->session->userdata('username');
        }
        else
        {
            $this->player = $players_records[0]['player'];
        }
        
        // fill Player dropdown
        $players = array();
        foreach ($players_records as $record)
        {
            $record['selected'] = NULL;
            
            if($record['player'] === $this->player)
            {
                $record['selected'] = 'selected="selected"';
            }
            $players[] = (array) $record;
        }
        $this->data['players'] = $players;
    }
    
    
    function create_holdings_pane()
    {
        $data_pieces = $this->collections->get_pieces(array('player'=>$this->player));

        // fill holdings table
        $series = array();
        foreach ($data_pieces as $record)
        {
            $series[] = (array) $record;
        }
        $this->data['series'] = $series;
        
        // get number of peanuts
        $player_record = $this->players->get(array('player'=>$this->player));
        $this->data['peanuts'] = $player_record['peanuts'];
        
    }
    
    function create_activity_pane()
    {
        // get this player's purchases
        $purchase_records = $this->transactions->get_all(array('player'=>$this->player,'trans'=>'buy'));
        
        // turn purchase records into properly formatted array
        $purchases = array();
        foreach($purchase_records as $record)
        {
            $purchases[] = array('purchase_date'=>$record['datetime']);
        }
        $this->data['purchases'] = $purchases;
        
        // get this player's sales
        $sales_records = $this->transactions->get_all(array('player'=>$this->player,'trans'=>'sell'));
        
        // turn sale records into properly formatted array
        $sales = array();
        foreach($sales_records as $record)
        {
            $sales[] = array('sale_date'=>$record['datetime'],'sale_series'=>$record['series']);
        }
        $this->data['sales'] = $sales;
    }
    
    function buy_cards()
        {  
            // purchase cards, send required info to purchase model
            //team: your team code 'A04'
            // token: your agent authentication token
            // player: the name of your player 

        
            $team = "A04"; // team name
            $token = $this->agent->get_token(); // token, team must have been registered

            $player =  $this->session->userdata('username'); // current playername stored in session data
    
            $success = $this->purchase->purchase($team,$token,$player); 
            $buy_message = $success;
            $this->session->set_flashdata('last_buy', $buy_message); //record feedback message
            redirect('portfolio'); // reload the page
            
            
            
        }
    

}

/* End of file Portfolio.php */
/* Location: application/controllers/Portfolio.php */
