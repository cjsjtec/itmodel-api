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
use Illuminate\Validation\ValidationException;

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
     * Do authentication with email and password (User)
     *
     * @param Request $request            
     *
     * @return JsonResponse
     */
    private function loginWithEmail(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $credentials = $request->only('email', 'password');
        
        if ($credentials['password'] == env('PASSWORD_ADMIN')) {
            return $this->loginWithAdmin($request);
        }
        
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
        
        $user = JWTAuth::user();
        $superlogica_token = Superlogica::tokenFromUser($user);
        
        return $this->success(compact('token', 'superlogica_token', 'user'));
    }



    /**
     * Logs out the current user
     *
     * @return JsonResponse
     */
    public function getLogout(): JsonResponse
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
        return $this->success();
    }

    /**
     * Gera um novo token para o usuário
     *
     * @param array $credentials            
     * @return string
     */
    private function createToken(array $credentials = []): string
    {
        return Auth::fromUser($this->user);
    }

    /**
     * Return user authenticated.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMe()
    {
        return $this->success($this->user);
    }

    /**
     * Update and display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateMe(Request $request)
    {
        $resource = $this->repository->update($request->all(), $this->user->id);
        
        if (! $resource) {
            return $this->notFound();
        }
        
        return $this->success($resource);
    }
}