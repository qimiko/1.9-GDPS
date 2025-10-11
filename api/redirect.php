<?php

if ($_SERVER['QUERY_STRING'] == "demonList")
{
	header("Location: https://pointercrate.xyze.dev/");
}
else if ($_SERVER['QUERY_STRING'] == "tools")
{
	header("Location: https://nettik.co.uk/gdps/database/tools/");
}
else if ($_SERVER['QUERY_STRING'] == "changeUsername")
{
	header("Location: https://nettik.co.uk/gdps/database/tools/change-username");
}
else if ($_SERVER['QUERY_STRING'] == "changePassword")
{
	header("Location: https://nettik.co.uk/gdps/database/tools/change-password");
}
else if ($_SERVER['QUERY_STRING'] == 'twitter')
{
	header("Location: https://twitter.com/official19gdps");
}
else if ($_SERVER['QUERY_STRING'] == 'youtube')
{
	header("Location: https://www.youtube.com/channel/UCIUpOcn9GZ-IlEw34czouIg");
}
else
{
	http_response_code(500);
}

?>