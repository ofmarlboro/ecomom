<?php
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // 과거 아무 때나 잡으면 됨.
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

header( "HTTP/1.1 301 Moved Permanently" );
header("Location:./html/");
?>