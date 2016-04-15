<div class="row" id="dashboard">
    <div id="round-status">
        <h3>Game Status: Round #{round-number}</h3>
        <p>Round state: {round-state}</p>
        <p>Time left: {round-countdown}</p>
        <p>Agent: {round-agent}</p>
    </div>
    
    <div id="content-container">        

        <div id="content-left">
            <h3>Pieces</h3>
            <div id="homepage-series">
                <h4>Known Series</h4>
                {seriesdisplay}
            </div>            
            <div id="homepage-pieces">
                <h4>Known Pieces</h4>
                {piecedisplay}
            </div>

        </div>
        <div id="content-right">
            <h3>Players</h3>
            <div>
                {test}
                <div class="homepage-players">
                    <a href="/Portfolio?player={player}">{player}</a><img src="../data/uploads/{player}.jpg" height="30" width="30" >
					<br/><br/>
                    Peanuts: {peanuts}<br/><br/>
                    Equity: {equity}<br/>
                </div>
                {/test}
            </div>
            
            <h3 style="clear:both;">Transactions</h3>
            <div id="homepage-transactions">
                <table>
                    <tr>
                        <th>Player</th>
                        <th>Date/Time</th>
                        <th>Trans</th>
                        <th>Broker</th>
                        <th>Series</th>
                    </tr>
                {transactions}
                    <tr>
                        <td>{player}</td>
                        <td>{datetime}</td>
                        <td>{trans}</td>
                        <td>{broker}</td>
                        <td>{series}</td> 
                    </tr>               
                {/transactions}
                </table>
            </div>
            
            
        </div>
    </div>
</div>
