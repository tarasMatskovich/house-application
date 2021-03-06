<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:42
 */

namespace actions\auth\signup;


use app\factories\UserFactory\UserFactoryInterface;
use app\repositories\UserRepository\UserRepositoryInterface;
use app\request\validation\auth\signup\SignUpRequest;
use app\responders\UserResponder\UserResponderInterface;
use houseframework\action\ActionInterface;

/**
 * Class SignUp
 * @package actions\signup\SignUp
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
     * @var UserResponderInterface
     */
    private $userResponder;

    /**
     * SignUp constructor.
     * @param UserFactoryInterface $userFactory
     * @param UserRepositoryInterface $userRepository
     * @param UserResponderInterface $userResponder
     */
    public function __construct(
        UserFactoryInterface $userFactory,
        UserRepositoryInterface $userRepository,
        UserResponderInterface $userResponder
    )
    {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->userResponder = $userResponder;
    }


    /**
     * @param SignUpRequest $request
     * @return array
     * @throws \Exception
     */
    public function __invoke(SignUpRequest $request)
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
