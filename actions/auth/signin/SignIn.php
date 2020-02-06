<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:18
 */

namespace houseapp\actions\auth\signin;


use houseapp\app\repositories\UserRepository\UserRepositoryInterface;
use houseapp\app\request\validation\auth\signin\SignInRequest;
use houseapp\app\responders\UserResponder\UserResponderInterface;
use houseapp\app\services\AuthenticationService\AuthenticationServiceInterface;
use houseframework\action\ActionInterface;


/**
 * Class SignIn
 * @package houseapp\actions\auth\signin
 */
class SignIn implements ActionInterface
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var UserResponderInterface
     */
    private $userResponder;

    /**
     * SignIn constructor.
     * @param UserRepositoryInterface $userRepository
     * @param AuthenticationServiceInterface $authenticationService
     * @param UserResponderInterface $userResponder
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        AuthenticationServiceInterface $authenticationService,
        UserResponderInterface $userResponder
    )
    {
        $this->userRepository = $userRepository;
        $this->authenticationService = $authenticationService;
        $this->userResponder = $userResponder;
    }

    /**
     * @param SignInRequest $request
     * @return array
     * @throws \Exception
     */
    public function __invoke(SignInRequest $request)
    {
        $email = $request->getAttribute('email');
        $password = $request->getAttribute('password');
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            throw new \Exception('No existing user with such email', 403);
        }
        if (!$this->authenticationService->verifyUser($user, $password)) {
            throw new \Exception('Wrong password');
        }
        return [
            'user' => $this->userResponder->respond($user),
            'token' => $this->authenticationService->createToken($user)
        ];
    }
}
