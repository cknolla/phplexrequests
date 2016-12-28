<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tokens Controller
 *
 * @property \App\Model\Table\TokensTable $Tokens
 */
class TokensController extends AppController
{

	public function getToken()
	{
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$result = [];
			$result['success'] = 'no';
			$domain = $this->request->data('domain');

			$result['success'] = 'yes';
		} else {
			die;
		}

		$this->response->body(json_encode($result));
		return $this->response;
	}
}
