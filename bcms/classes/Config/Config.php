<?php
/*
 * Базовый конфигурационный файл
 */
// База данных
if (!defined("HOSTNAME")) {
	define("HOSTNAME", "localhost");
}	
if (!defined("USERNAME")) {
	define("USERNAME", "root");
}
if (!defined("PASSWORD")) {
	define("PASSWORD", "AiR5a299Ra");
}
if (!defined("DBNAME")) {
	define("DBNAME", "bcms");
}

// Admin
if (!defined("EMAIL")) {
	define("EMAIL", "ivan.bazhenov@gmail.com");
}