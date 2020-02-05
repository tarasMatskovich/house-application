<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:46
 */

namespace houseapp\app\services\AuthenticationService;


use houseapp\app\entities\User\UserInterface;
use houseapp\app\repositories\UserRepository\UserRepositoryInterface;
use houseapp\app\services\JWTService\AlgorithmsEnum;
use houseapp\app\services\JWTService\JWTServiceInterface;
use houseapp\app\services\UserPasswordService\UserPasswordServiceInterface;

/**
 * Class AuthenticationService
 * @package houseapp\app\services\AuthenticationService
 */
class AuthenticationService implements AuthenticationServiceInterface
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
     * @var JWTServiceInterface
     */
    private $JWTService;

    /**
     * AuthenticationService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserPasswordServiceInterface $userPasswordService
     * @param JWTServiceInterface $JWTService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordServiceInterface $userPasswordService,
        JWTServiceInterface $JWTService
    )
    {
        $this->userRepository = $userRepository;
        $this->userPasswordService = $userPasswordService;
        $this->JWTService = $JWTService;
    }

    /**
     * @param UserInterface $user
     * @return string
     * @throws \Exception
     */
    public function createToken(UserInterface $user)
    {
        $header = $this->makeHeader();
        $payload = $this->makePayload($user);
        return $this->JWTService->encode($header, $payload);
    }

    /**
     * @return array
     */
    private function makeHeader()
    {
        return [
            'alg' => AlgorithmsEnum::HS_256,
            'typ' => 'JWT'
        ];
    }

    /**
     * @param UserInterface $user
     * @return array
     * @throws \Exception
     */
    private function makePayload(UserInterface $user)
    {
        $data = new \DateTime();
        $currentTimeStamp = $data->getTimestamp();
        $expiredTimeStamp = $currentTimeStamp + 30000;
        return [
            'iss' => 'auth.securemessenger.com.ua',
            'aud' => 'securemessenger.com.ua',
            'userId' => $user->getId(),
            'exp' => $expiredTimeStamp
        ];
    }

    /**
     * @param string $token
     * @return bool
     * @throws \Exception
     */
    public function checkToken(string $token)
    {
        if (!$this->isValidTokenStructure($token)) {
            return false;
        }
        $parts = $this->explodeToken($token);
        $payload = $parts[1];
        $payload = base64_decode($payload);
        $payload = json_decode($payload, true);
        if (!isset($payload['userId'])) {
            return false;
        }
        $user = $this->userRepository->find($payload['userId']);
        if (null === $user) {
            return false;
        }
        if (!isset($payload['exp'])) {
            return false;
        }
        if (false === $this->isValidTokenDate($payload['exp'])) {
            return false;
        }
        if (false === $this->isValidTokenSign($token)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $token
     * @return bool
     */
    private function isValidTokenSign(string $token)
    {
        $parts = $this->explodeToken($token);
        $header = json_decode(base64_decode($parts[0]), true);
        $payload = json_decode(base64_decode($parts[1]), true);
        $sign = $parts[2];
        $systemToken = $this->JWTService->encode($header, $payload);
        $systemTokenSign = $this->explodeToken($systemToken)[2];
        return $sign === $systemTokenSign;
    }

    /**
     * @param $expTimestamp
     * @return bool
     * @throws \Exception
     */
    private function isValidTokenDate($expTimestamp)
    {
        return (new \DateTime())->getTimestamp() <= $expTimestamp;
    }

    /**
     * @param string $token
     * @return bool
     */
    private function isValidTokenStructure(string $token)
    {
        $parts = $this->explodeToken($token);
        return count($parts) === 3;
    }

    /**
     * @param string $token
     * @return array
     */
    private function explodeToken(string $token): array
    {
        return explode('.', $token);
    }

    /**
     * @param UserInterface $user
     * @param string $password
     * @return bool
     */
    public function verifyUser(UserInterface $user, string $password): bool
    {
        return $this->userPasswordService->checkPassword($user, $password);
    }
}
