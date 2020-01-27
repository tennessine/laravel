<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class MiniprogramService {
	private $client;

	public function __construct(GuzzleHttp\Client $client) {
		$this->client = $client;
	}

	public function getAccessToken() {
		if (!Cache::has('access_token')) {
			$response = $this->client->request('GET', 'https://api.weixin.qq.com/cgi-bin/token', [
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

	public function subscribeMessageSend($openid, $template_id, $page = null, $data = []) {

		$response = $this->client->post('https://api.weixin.qq.com/cgi-bin/message/subscribe/send', [
			'query' => ['access_token' => $this->getAccessToken()],
			'json' => [
				'touser' => $openid,
				'template_id' => $template_id,
				'page' => $page,
				'data' => $data,
			],
		]);

		$result = GuzzleHttp\json_decode($response->getbody()->getContents(), true);
		if (array_key_exists('errcode', $result) && array_key_exists('errmsg', $result)) {
			return [
				'errcode' => $result['errcode'],
				'errmsg' => $result['errmsg'],
			];
		}

		return $result;
	}
}