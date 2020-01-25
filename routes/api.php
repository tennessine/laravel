<?php

use Illuminate\Http\Request;

Route::post('/upload', function (Request $request) {
	$file = $request->file('file');
	return $file->getClientOriginalName();
});
