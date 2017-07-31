<?php
namespace App\Http\Controllers\Auth;

use Lab123\Odin\Controllers\ApiController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Traits\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends ApiController
{
	use ResetsPasswords;

	public function __construct()
	{
		$this->broker = 'users';
	}

	/**
	 * Get the response for after the reset link has been successfully sent.
	 *
	 * @param string $response
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function getSendResetLinkEmailSuccessResponse($response)
	{
		return $this->success([
				'message' => trans($response)
		]);
	}

	/**
	 * Get the response for after the reset link could not be sent.
	 *
	 * @param string $response
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function getSendResetLinkEmailFailureResponse($response)
	{
		return $this->bad([
				'message' => trans($response)
		]);
	}

	/**
	 * Get the response for after a successful password reset.
	 *
	 * @param string $response
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function getResetSuccessResponse($response)
	{
		return $this->success([
				'message' => trans($response)
		]);
	}

	/**
	 * Get the response for after a failing password reset.
	 *
	 * @param Request $request
	 * @param string $response
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function getResetFailureResponse(Request $request, $response)
	{
		return $this->bad([
				'message' => trans($response)
		]);
	}
}