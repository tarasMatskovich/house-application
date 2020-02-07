<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 11:14
 */

namespace houseapp\app\services\Authentication\Authenticator;


use houseapp\app\entities\User\UserInterface;
use houseapp\app\repositories\UserRepository\UserRepositoryInterface;
use houseapp\app\services\Authentication\AuthenticationPayload\AuthenticationPayload;
use houseapp\app\services\Authentication\AuthenticationPayload\AuthenticationPayloadInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class JWTAuthenticator
 * @package houseapp\app\services\Authentication\Authenticator
 */
class JWTAuthenticator implements AuthenticatorInterface
{

    const HS_256 = 'HS256';

    const PHP_HS_256 = 'SHA256';

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var int
     * default - 24h
     */
    private $jwtLifeTime = 60 * 60 * 24;

    /**
     * JWTAuthenticator constructor.
     * @param UserRepositoryInterface $userRepository
     * @param string $secret
     * @param float|int|null $lifetime
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        string $secret,
        $lifetime = null
    )
    {
        $this->userRepository = $userRepository;
        $this->secret = $secret;
        if ($this->jwtLifeTime) {
            $this->jwtLifeTime = $lifetime;
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     * @throws \Exception
     */
    public function auth(ServerRequestInterface $request)
    {
        $token = $request->getAttribute('token');
        if (!$token) {
            return false;
        }
        return $this->checkToken($token);
    }

    /**
     * @param UserInterface $user
     * @return AuthenticationPayloadInterface
     * @throws \Exception
     */
    public function getAuthPayload(UserInterface $user)
    {
        $header = $this->makeHeader();
        $payload = $this->makePayload($user);
        $jwt = $this->encode($header, $payload);
        return new AuthenticationPayload($jwt);
    }

    /**
     * @param array $header
     * @param array $payload
     * @return string
     */
    private function encode(array $header, array $payload): string
    {
        $unsignedToken = $this->makeUnsignedToken($header, $payload);
        $signature = $this->makeSignature($header, $unsignedToken);
        return $unsignedToken . '.' . $signature;
    }

    /**
     * @param array $header
     * @param string $unsignedToken
     * @return string
     */
    private function makeSignature(array $header, string $unsignedToken): string
    {
        $algorithm = $header['alg'] ?? '';
        switch ($algorithm) {
            case static::HS_256:
                return hash_hmac(static::PHP_HS_256, $unsignedToken, $this->secret);
            default:
                return hash_hmac($algorithm, $unsignedToken, $this->secret);
        }
    }

    /**
     * @param array $header
     * @param array $payload
     * @return string
     */
    private function makeUnsignedToken(array $header, array $payload): string
    {
        $header = json_encode($header);
        $payload = json_encode($payload);
        $unsignedToken = base64_encode($header) . '.' . base64_encode($payload);
        return $unsignedToken;
    }

    /**
     * @return array
     */
    private function makeHeader()
    {
        return [
            'alg' => static::HS_256,
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
        $expiredTimeStamp = $currentTimeStamp + $this->jwtLifeTime;
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
    private function checkToken(string $token)
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
        $sign = $parts[2] ?? null;
        if (!$header || !$payload || !$sign) {
            return false;
        }
        $systemToken = $this->encode($header, $payload);
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
}
