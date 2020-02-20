<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:28
 */

namespace houseapp\actions\test;


use houseframework\action\ActionInterface;
use houseframework\app\publisher\message\PublisherMessage;
use houseframework\app\publisher\PublisherInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class Test
 * @package houseapp\actions\test
 */
class Test implements ActionInterface
{

    /**
     * @var PublisherInterface
     */
    private $publisher;

    /**
     * Test constructor.
     * @param PublisherInterface $publisher
     */
    public function __construct(
        PublisherInterface $publisher
    )
    {
        $this->publisher = $publisher;
    }

    /**
     * @param ServerRequestInterface $request
     * @return array
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $attr = $request->getAttribute('foo');
        $this->publisher->publish(new PublisherMessage('topic', 'dasdasd'));
        return [
            'foo' => $attr
        ];
    }
}
