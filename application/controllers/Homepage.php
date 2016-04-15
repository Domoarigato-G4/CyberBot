<?php

/**
 * Our homepage. Show a panel with overall game status and displays bot pieces 
 * player is aware of. Then another panel displays all other player's, their
 * equity, and cash, as well as the ability to view each player's portfolio.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Homepage extends Application {

	function __construct()
	{
		parent::__construct();
		$this->load->model('players');
                $this->load->model('series');
		$this->load->model('collections');
                $this->load->model('certificates');
                $this->load->model('transactions');
		$this->load->model('gamestate');
                $this->load->model('agent');
	}

	//-------------------------------------------------------------
	//  The normal pages
	//-------------------------------------------------------------
        
        
	function index()
	{
		$this->data['title'] = 'Homepage';
		$this->data['pagebody'] = 'homepage';	// this is the view we want shown
		// build the list of authors, to pass on to our view

                //calls the welcome_series function
                $this->welcome_series();
		//calls the welcome_pieces function
                $this->welcome_pieces();
		//calls the welcome_players function
		$this->welcome_players();
                //calls the welcome_states function
                $this->welcome_states();
                //calls the welcome_transactions function
                $this->welcome_transactions();
		//renders the page
		$this->render();
	}
        
        //get the series from the server and display
        private function welcome_series()
        {
            $results = '';
            foreach($this->series->all() as $series)
            {
                $results .= $this->parser->parse('_seriescell', $series, true);
            }
            
            $this->data['seriesdisplay'] = $results;
        }
        
        //get the pieces from the server and display (doesn't work yet)
        private function welcome_pieces()
        {
            //use the collections::all() method and put it into the allpieces variable
            $allpieces = $this->certificates->distinct_all();
            $results = ''; 
            foreach ($allpieces as $row)
            {
                    $results .= $this->parser->parse('_homepagecell', $row, true);
            }	
            $this->data['piecedisplay'] = $results; 
        }
        
        //get the state from the server and display
        private function welcome_states()
        {
            $this->gamestate->refresh();
            $this->data['round-number'] = $this->gamestate->get_round();
            $this->data['round-state'] = $this->gamestate->get_state();
            $this->data['round-countdown'] = $this->gamestate->get_countdown();
            $this->data['round-agent'] = $this->agent->is_registered() ? "Registered" : "Not registered";
        }


	private function welcome_players()
	{
		//get all the players from our model
		$players = $this->players->all(); 

		
		$players_array = array ();
		foreach ($players as $player)
		{
			$player['equity'] = $this->players->equity($player['player']);
			$players_array[] = (array) $player;
		}
		$this->data['test'] = $players_array; 
	}

        //get the transactions from the server and display
        private function welcome_transactions()
        {
            $transactions = $this->transactions->all();
            $this->data['transactions'] = array_reverse(array_slice($transactions, -5, 5, TRUE),TRUE);
        }

}

/* End of file Homepage.php */
/* Location: application/controllers/Homepage.php */