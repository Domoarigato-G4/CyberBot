<div id="admin-wrapper">
    <div id="admin-status">
        <h2>Game Status: Round #{round-number}</h2>
        <p>Round state: {round-state}</p>
        <p>Time left: {round-countdown}</p>
    </div>

    <div id="admin-register">
        <h2>Registration</h2>
        <p id="register-status">Status: {register-status}</p>
        <form autocomplete="off" method="post" action="admin/register">
            <label for="team">Team:</label><input type="text" name="team" value="{register-team}" /> <br>
            <label for="name">Name:</label><input type="text" name="name" value="{register-name}" /> <br>
            <label for="password">Password:</label><input type="text" name="password" value="{register-password}" /> <br>
            <button type="submit" name="register" formaction="admin/register">Force Register</button> <br>
            <button type="submit" name="update" formaction="admin/update">Update Data</button>
        </form>
    </div>

    <div id="admin-rounds">
        <h2>Known Rounds</h2>
        {rounds}
        <p>Round {round}: {token}</p>
        {/rounds}
        <form autocomplete="off" method="post" action="admin/purge">
            <button type="submit" name="purge">Purge Known Rounds</button>            
        </form>
    </div>

    <div id="admin-info">
        <h2>Information</h2>
        <p>{message}</p>
    </div>

	<div id="admin-player-mgmt">
        <h2>Player Management</h2>
		<table id="admin-players">
			<tr>
				<th>Player Name</th>
				<th>Peanuts</th>
				<th>Admin Role</th>
				<th>Avatar Image Path</th>
				<th>Toggle Admin Status</th>
				<th>Delete Player</th>
			</tr>
			{adminplayertable}
			<tr>
				<td>
					{player}
				</td>
				<td>
					{peanuts}
				</td>
				<td>
					{adminrole}
				</td>
				<td>
					{imgpath}
				</td>
				<td>
					<form autocomplete="off" method="post" action="admin/toggle">
						<input type="text" name="player" value="{player}" style="display: none" />
						<input type="text" name="role" value="{adminrole}" style="display: none" />
						<button type="submit" name="toggle" formaction="admin/toggle">Grant/Revoke Admin</button>
					</form>
				</td>
				<td>
					<form autocomplete="off" method="post" action="admin/delete">
						<input type="hidden" name="deleteplayer" value="{player}" />
						<button type="submit" name="delete" formaction="admin/delete">Delete</button>
					</form>
				</td>
			</tr>
			{/adminplayertable}
		</table>
    </div>
</div>
