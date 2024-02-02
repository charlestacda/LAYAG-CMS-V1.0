<?php

include ('includes/config.php');

session_destroy();

header('Location: /layag_cms');
die();