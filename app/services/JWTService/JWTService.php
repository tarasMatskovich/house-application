<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:53
 */

namespace houseapp\app\services\JWTService;


/**
 * Class JWTService
 * @package houseapp\app\services\JWTService
 */
class JWTService implements JWTServiceInterface
{

    /**
     * @var string
     */
    private $secret;

    /**
     * JWTService constructor.
     * @param string $secret
     */
    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param array $header
     * @param array $payload
     * @return string
     */
    public function encode(array $header, array $payload): string
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
            case AlgorithmsEnum::HS_256:
                return hash_hmac(AlgorithmsEnum::PHP_HS_256, $unsignedToken, $this->secret);
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

}
