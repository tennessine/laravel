<?php

use Illuminate\Http\Request;

Route::post('/upload', function (Request $request) {
	$file = $request->file('file');
	// wx9272a2c1b71081f4.o6zAJszrdmwFQCryome-HIFrEQaI.cFCK7ArKXwFm0e65e9c559c051ee27aaa2c23730b825.png
	// $file->getClientOriginalName();
	//
	return $file->getClientOriginalExtension();
});
