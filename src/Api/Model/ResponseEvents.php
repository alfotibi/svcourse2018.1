<?php
namespace Course\Api\Model;

use Course\Api\Exceptions\ApiException;
use Course\Api\Exceptions\Precondition;

class ResponseEvents {
//    const AUTHORIZE = 'authorize';
    const START_GAME = 'startGame';
    const ALLOWED_EVENTS = [
        self::START_GAME
    ];

    private static $room = null;

    /**
     * @param $data
     * @return Event
     * @throws \Course\Api\Exceptions\PreconditionException
     * @throws ApiException
     */
    public static function getEvent($data) {
        $explode = explode(':', $data, 2);
        if (count($explode) !== 2) {
            throw new ApiException('socket message should be in this form event:jsonBody');
        }
        list($eventType, $jsonBody) = $explode;
        Precondition::isInArray($eventType, self::ALLOWED_EVENTS, 'eventType');
        $decodedBody = @json_decode($jsonBody);
        Precondition::isNotEmpty($decodedBody, 'decodedBody');
        $eventClassName = __NAMESPACE__ . "\\" .ucfirst($eventType) . "Event";
        var_dump($decodedBody);
        return new $eventClassName($eventType, $decodedBody);
    }
}