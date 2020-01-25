<?php

use Illuminate\Http\Request;

Route::post('/upload', function (Request $request) {
	info($request->all());
	return [
		'code' => 200,
		'msg' => 'success',
	];
});
