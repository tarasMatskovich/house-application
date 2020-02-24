<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 14:56
 */

namespace app\factories\UserFactory;


use app\entities\User\User;
use app\entities\User\UserInterface;
use app\repositories\UserRepository\UserRepositoryInterface;
use app\services\UserPasswordService\UserPasswordServiceInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class UserFactory
 * @package app\factories\UserFactory
 */
class UserFactory implements UserFactoryInterface
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserPasswordServiceInterface
     */
    private $userPasswordService;

    /**
     * UserFactory constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserPasswordServiceInterface $userPasswordService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordServiceInterface $userPasswordService
    )
    {
        $this->userRepository = $userRepository;
        $this->userPasswordService = $userPasswordService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return UserInterface|null
     */
    public function makeUserFromSignInRequest(ServerRequestInterface $request)
    {
        $userId = $request->getAttribute('userId');
        $user = $this->userRepository->find($userId);
        return $user;
    }

    /**
     * @param ServerRequestInterface $request
     * @return UserInterface
     */
    public function makeUserFromSignUpRequest(ServerRequestInterface $request)
    {
        $name = $request->getAttribute('name');
        $email = $request->getAttribute('email');
        $password = $this->userPasswordService->generateHash($request->getAttribute('password'));
        $user = new User(
            $name,
            $email,
            $password
        );
        return $user;
    }
}
