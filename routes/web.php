<?php

use Symfony\Component\Process\Process;

Route::post('/deploy', function () {
	$root_path = base_path();
	$process = new Process('cd ' . $root_path . '; ./deploy.sh');
	$process->run(function ($type, $buffer) {
		echo $buffer;
	});
});