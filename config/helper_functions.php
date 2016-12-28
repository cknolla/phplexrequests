<?php

use Cake\ORM\TableRegistry;

function getVariable($alias)
{
	$variablesTable = TableRegistry::get('Variables');
	$variable = $variablesTable->find('all', [
		'conditions' => [
			'alias' => $alias
		]
	])->first();
	if($variable) {
		return $variable->value;
	}
	return null;
}

function getToken($domain)
{
	if($domain == "https://api.thetvdb.com") {
		$existingToken = \Cake\ORM\TableRegistry::get('Tokens')->find('all', [
			'conditions' => [
				'domain' => $domain,
				'expires <' => '',
			]
		]);
		$credentials = [
			'apikey' => getVariable('theTvDbApikey'),
		];
		$http = new \Cake\Http\Client();
		$response = $http->post('https://api.thetvdb.com/login',
			json_encode($credentials),	[
				'type' => 'json',
			]);
	}
}