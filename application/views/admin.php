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
            <label for="team">Team:</label><input type="text" name="team" /> <br>
            <label for="name">Name:</label><input type="text" name="name" /> <br>
            <label for="password">Password:</label><input type="text" name="password" /> <br>
            <input type="submit" value="Register"/>
        </form>
    </div>

    <div id="admin-rounds">
        <h2>Known Rounds</h2>
        {rounds}
        <p>Round {round}: {token}</p>
        {/rounds}
    </div>

    <div id="admin-info">
        <h2>Information</h2>
        <p>{message}</p>
    </div>
</div>
