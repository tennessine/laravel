<?php

use Illuminate\Http\Request;

Route::post('/upload', function (Request $request) {
	$file = $request->file('file');

	// wx9272a2c1b71081f4.o6zAJszrdmwFQCryome-HIFrEQaI.cFCK7ArKXwFm0e65e9c559c051ee27aaa2c23730b825.png
	// $file->getClientOriginalName();

	// png
	// return $file->getClientOriginalExtension();

	// /tmp/phpBoaM13
	// return $file->getRealPath();

	// 51329 b
	// return $file->getSize();

	// image/png
	// return $file->getMimeType();

	// upload
	// $file->move('uploads/foo/bar/baz', $file->getClientOriginalName());
});

Route::post('/login', function (Request $request, GuzzleHttp\Client $client) {
	$code = $request->code;

	$response = $client->request('GET', 'https://api.weixin.qq.com/sns/jscode2session', [
		'query' => [
			'appid' => config('miniprogram.AppID'),
			'secret' => config('miniprogram.AppSecret'),
			'js_code' => $code,
			'grant_type' => 'authorization_code',
		],
	]);

	$result = \Guzzle\json_decode($response->getbody()->getContents(), true);
	info($result);
});
