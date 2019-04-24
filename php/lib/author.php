<?php
// setup require_onces, namespaces (make sure to include both autoloaders
// use the new keyword to call the constructor in the class and add all required parameters
//  var_dump() the result from the step above

require_once(dirname(__DIR__) . "/vendor/autoload.php");
require_once(dirname(__DIR__) . "/Classes/autoload.php");

use Snelson54\ObjectOriented\Author;

	$authorId = new Author('68fb073ca8494305b623c8cc061710c6', 'google.com', '667567', 'snelson54@cnm.edu', 'snelson54', '$argon2i$v=19$m=1024,t=384,p=2$T1B6Ymdqa3FJdmZqaDdqYg$hhyC1jf2WjbgfD8Jp6GZE9Tg3IpsYpXKm2VWYOJq8LA');

var_dump($authorId);