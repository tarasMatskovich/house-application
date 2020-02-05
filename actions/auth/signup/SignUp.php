<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:42
 */

namespace houseapp\actions\auth\signup;


use houseapp\app\factories\UserFactory\UserFactoryInterface;
use houseapp\app\repositories\UserRepository\UserRepositoryInterface;
use houseapp\app\responders\UserResponder\UserResponderInterface;
use houseapp\app\services\AuthenticationService\AuthenticationServiceInterface;
use houseframework\action\ActionInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class SignUp
 * @package houseapp\actions\signup\SignUp
 */
class SignUp implements ActionInterface
{

    /**
     * @var UserFactoryInterface
     */
    private $userFactory;

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
     * SignUp constructor.
     * @param UserFactoryInterface $userFactory
     * @param UserRepositoryInterface $userRepository
     * @param AuthenticationServiceInterface $authenticationService
     * @param UserResponderInterface $userResponder
     */
    public function __construct(
        UserFactoryInterface $userFactory,
        UserRepositoryInterface $userRepository,
        AuthenticationServiceInterface $authenticationService,
        UserResponderInterface $userResponder
    )
    {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->authenticationService = $authenticationService;
        $this->userResponder = $userResponder;
    }


    /**
     * @param ServerRequestInterface $request
     * @return array
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $user = $this->userFactory->makeUserFromSignUpRequest($request);
        $existingUser = $this->userRepository->findOneBy(['email' => $user->getEmail()]);
        if ($existingUser) {
            throw new \Exception("User with same email is already exist");
        }
        $this->userRepository->save($user);
        return $this->userResponder->respond($user);
    }
}
