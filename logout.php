<?php
require('config/db_connect.php');

// Destroy all sessions and redirect user to homepage 
session_destroy();
header("Location: index.html");
