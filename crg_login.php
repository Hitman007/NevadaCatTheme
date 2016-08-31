<div id = "name_request_div" class = "form_section" style="display:<?php echo $name_request_div_dispay?>">
	<label for = "user_first_name">First Name:</label>
		<input type = "input" name = "user_first_name" id = "user_first_name" />
			<div id = "user_first_name_error_msg" class = "error_msg"><?php echo ($user_first_name_error_msg); ?></div>
	<label for = "user_last_name">Last Name:</label>
		<input type = "input" name = "user_last_name" id = "user_last_name" />
			<div id = "user_last_name_error_msg" class = "error_msg"><?php echo ($user_last_name_error_msg); ?></div>
	<label for = "user_display_name">"Display" Name:</label>
		<input type = "input" id = "user_display_name" />
			<div id = "user_display_name_error_msg" class = "error_msg"><?php echo ($user_display_name_error_msg); ?></div>
</div>
