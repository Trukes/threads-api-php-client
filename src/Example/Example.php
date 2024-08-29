<?php

namespace Trukes\ThreadsApiPhpClient\Example;

require "vendor/autoload.php";

use Trukes\ThreadsApiPhpClient\Threads;



$reference = Threads::client('389032777277944|1deTeboDhCg7b4Ti5RHY0Ylw1cM');

$create = $reference->publish()->status("1234", 'id,status,error_message')->data();

var_dump($create);
