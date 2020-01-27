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

Route::get('/subscribeMessageSend', function (App\Services\MiniprogramService $miniprogramService) {

	$data = [];

	$miniprogramService->subscribeMessageSend('o_Gtt5R6PfG22CVoJxtzRo5dwzh4', '4SrCs6shl1GOqrLvVd29To3abvd0L-IRBLk_X6JXisA', '/pages/index/index', $data);
});

Route::post('/login', function (Request $request, GuzzleHttp\Client $client) {
	$response = $client->request('GET', 'https://api.weixin.qq.com/sns/jscode2session', [
		'query' => [
			'appid' => config('miniprogram.AppID'),
			'secret' => config('miniprogram.AppSecret'),
			'js_code' => $request->code,
			'grant_type' => 'authorization_code',
		],
	]);
	$result = \GuzzleHttp\json_decode($response->getbody()->getContents(), true);
	if (array_key_exists('errcode', $result) && array_key_exists('errmsg', $result)) {
		return [
			'errcode' => $result['errcode'],
			'errmsg' => $result['errmsg'],
		];
	}
	$session_key = $result['session_key'];
	$openid = $result['openid'];
	return $result;
});