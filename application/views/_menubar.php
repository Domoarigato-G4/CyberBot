<?php
/*
 * Menu navbar, just an unordered list
 */
?>
<h2>Cyberbots Web App</h2>
<div id="loginbox">
    <div id="loginmessage">{login_message}</div>
    <span id="logintext">{login_text}</span>
    <form name="loginform" id="loginform" autocomplete="off" method="POST">
        <input type="text" name="username" placeholder="Username" style="display:{login_visibility}">
        <input type="text" name="action" value="{login_action}" style="display:none">
		<input type="text" name="password" placeholder="password" style="display:{login_visibility}">
        <input type="submit" value="{login_submit_text}">
		<a href="registration/" style="display:{login_visibility}">Click here to Register</a>
    </form>    
</div>
<ul class="nav">    
    {menudata}
    <li><a href="{link}">{name}</a></li>
    {/menudata}
</ul>

