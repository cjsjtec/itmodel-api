<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use App\Entities\Auth\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;
use Lab123\Odin\Traits\ApiResponse;
use App\Repositories\Auth\UserRepository;
use Lab123\Odin\Requests\FilterRequest;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     *
     * @var UserRepository $repository
     */
    protected $repository;

    /**
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        if (Auth::check()) {
            $this->user = Auth::user();
        }
    }

    /**
     * Route Authentication
     *
     * @param Request $request            
     *
     * @return JsonResponse
     */
    public function postLogin(FilterRequest $request): JsonResponse
    {
    	$fieldManager = $this->repository->getFieldManager();
    	
    	$this->validate($request->request, $fieldManager->autenticate());
    	
    	$credentials = $request->only('email', 'password');
		
    	try {
    		if (! $token = JWTAuth::attempt($credentials)) {
    			
    			return $this->unauthorized([
    					'message' => 'invalid_credentials'
    			]);
    		}
    	} catch (JWTException $e) {
    		return $this->exception([
    				'message' => 'could_not_create_token'
    		]);
    	}
    	
    	$user = Auth::user();
    	
    	return $this->success(compact('token', 'user'));
    }

    /**
     * Logs out the current user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
    	Auth::logout();
        return $this->success();
    }

    /**
     * Generate a new token to the current user
     *
     * @return JsonResponse
     */
    public function getRefresh(): JsonResponse
    {
        if (! $token = Auth::parseToken()->refresh()) {
            return $this->success();
        }
        
        Auth::setToken($token);
        $this->user = Auth::user();
        return $this->success([
            'token' => $this->createToken()
        ]);
    }

    /**
     * Validate if the current token is not expired (middleware)
     *
     * @return JsonResponse
     */
    public function getValidate(): JsonResponse
    {
    	$this->user = Auth::user();
    	
    	if (Auth::check()) {
    		
    		$token = JWTAuth::fromUser(Auth::user());
    		
    		return $this->success(['token' => $token]);
    	}
    	
    	return $this->unauthorized();
    }

    /**
     * Gera um novo token para o usuário
     *
     * @param array $credentials            
     * @return string
     */
    private function createToken(array $credentials = []): string
    {
    	return Auth::fromUser(Auth::user());
    }
}