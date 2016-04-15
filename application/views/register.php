<div class="body">
	<h1>Fill out form:</h1>
	<div id="registration-wrapper"> 
			<form name="registerform" id="registerform" autocomplete="off" method="POST" enctype="multipart/form-data">
				<table id="registertable">
					<tr>
						<td>Username: </td>
						<td><input type="text" name="player" placeholder="username"><div class="register" style="display:{username_visibility}">{username_message}</div></td>
					</tr>
					<tr>
						<td>Password: </td>
						<td><input type="password" name="password" placeholder="password"><div class="register" style="display:{password_visibility}">{password_message}</div></td>
					</tr>
					<tr>
						<td>Upload avatar: <i>(max: 160px by 160px and .jpg only)</i></td>
						<td><input type="file" name="userfile" size="20" /><div class="register" style="display:{avatar_visibility}">{avatar_message}</div></td>
					</tr>
					<tr>
						<td><div class="register" style="display:{reg_visibility}">{register_success}</div></td>
						<td><input type="submit" value="Register"></td>
					</tr>
					<tr>
						<td colspan="2">
							<div style="display:{reg_visibility}">
								Sign-in via the login in the menubar above or <a href="/">click here to go home.</a>
							</div>
						</td>
					</tr>
				</table>
			</form> 
		
	</div>        
</div>