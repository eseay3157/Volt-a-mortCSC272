<?php

/**
 * Configuration for database connection
 *
 */

$host       = "172.16.22.21";
$username   = "TEAM_VAM";
$password   = "Summer20!9";
$dbname     = "TEAM_VAM";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );