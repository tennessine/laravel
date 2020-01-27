<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

// openid: o_Gtt5R6PfG22CVoJxtzRo5dwzh4

class MiniprogramService {
	public function getAccessToken(GuzzleHttp\Client $client) {
		if (!Cache::has('access_token')) {
			$response = $client->request('GET', 'https://api.weixin.qq.com/cgi-bin/token', [
				'query' => [
					'appid' => config('miniprogram.AppID'),
					'secret' => config('miniprogram.AppSecret'),
					'grant_type' => 'client_credential',
				],
			]);
			$result = \GuzzleHttp\json_decode($response->getbody()->getContents(), true);
			if (array_key_exists('errcode', $result) && array_key_exists('errmsg', $result)) {
				return [
					'errcode' => $result['errcode'],
					'errmsg' => $result['errmsg'],
				];
			}

			$access_token = $result['access_token'];
			$expires_in = $result['expires_in'];

			cache(['access_token' => $access_token], now()->addSeconds($expires_in));
		}

		return cache('access_token');
	}
}