
<div id="portfolio-wrapper"> 
	<form name="playerform" id="playerform" autocomplete="off">
		<span class="portfolio-label">Player: </span>
		<select name="player" onchange="playerform.submit()">
			{players}
			<option value="{player}" {selected}>{player}</option>
			{/players}
		</select>
	</form>
	<div id="avatar">
		<img src="./data/uploads/{name}.jpg" />
	</div>
	<div id="content-container">
		<div id="buy-container">
			<form autocomplete="off" method="post" action="portfolio/buy_cards">
				<input type="submit" value="Purchase Cards"/>
			</form>
			{buy_response}
        </div> 

		<div id="content-left">

			<h2>Current Holdings</h2>

			<table id="part-table" style="width: 90%">
				<tr>
					<th class="table-title">Series 11</th>
					<th class="table-title">Series 13</th>
					<th class="table-title">Series 26</th>
					<th></th>
				</tr>
				{series}
				<tr>
					<td>{11}</td>
					<td>{13}</td>
					<td>{26}</td>
					<td class="table-title">{piece}</td>
				</tr>
				{/series}
			</table>

			<div>
				<span class="portfolio-label">Peanuts:</span>
				<span id="peanuts">{peanuts}</span>
			</div>

		</div>

		<div id="content-right">
			<h2>Trading Activity</h2>

			<h3>Purchases</h3>
			<div id="purchases">
				{purchases}
				<p>{purchase_date} : Card Pack</p>
				{/purchases}
			</div>

			<h3>Sales</h3>
			<div id="sales">
				{sales}
				<p>{sale_date} : Series {sale_series}</p>
				{/sales}
			</div>

		</div>        
	</div>
</div>