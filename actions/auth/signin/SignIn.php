<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:18
 */

namespace actions\auth\signin;


use app\repositories\UserRepository\UserRepositoryInterface;
use app\request\validation\auth\signin\SignInRequest;
use app\responders\UserResponder\UserResponderInterface;
use app\services\Authentication\Authenticator\AuthenticatorInterface;
use app\services\UserPasswordService\UserPasswordServiceInterface;
use houseframework\action\ActionInterface;


/**
 * Class SignIn
 * @package actions\auth\signin
 */
class SignIn implements ActionInterface
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserResponderInterface
     */
    private $userResponder;

    /**
     * @var UserPasswordServiceInterface
     */
    private $userPasswordService;

    /**
     * @var AuthenticatorInterface
     */
    private $authenticator;

    /**
     * SignIn constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserResponderInterface $userResponder
     * @param UserPasswordServiceInterface $userPasswordService
     * @param AuthenticatorInterface $authenticator
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserResponderInterface $userResponder,
        UserPasswordServiceInterface $userPasswordService,
        AuthenticatorInterface $authenticator
    )
    {
        $this->userRepository = $userRepository;
        $this->userResponder = $userResponder;
        $this->userPasswordService = $userPasswordService;
        $this->authenticator = $authenticator;
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
        if (!$this->userPasswordService->checkPassword($user, $password)) {
            throw new \Exception('Wrong password');
        }
        return [
            'user' => $this->userResponder->respond($user),
            'token' => $this->authenticator->getAuthPayload($user)->getMainData()
        ];
    }
}
