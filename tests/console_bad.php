<?php

require __DIR__ . "/../bootstrap/start.php";

$prev = new DomainException("Previous message");
throw new Exception("Message here", 10, $prev);