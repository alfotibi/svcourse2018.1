<?php
namespace Course\Api\Model;

use Course\Api\Exceptions\Precondition;
use Course\Services\Authentication\Authentication;

class JoinRoomEvent extends Event {

    /**
     * StartGameEvent constructor.
     * @param object $data
     * @throws \Course\Api\Exceptions\PreconditionException
     * @throws \Course\Services\Authentication\Exceptions\DecryptException
     */
    public function __construct(object $data)
    {
        parent::__construct(Events::JOIN_ROOM, $data);
    }

    /**
     * @throws \Course\Services\Persistence\Exceptions\ConnectionException
     * @throws \Course\Services\Persistence\Exceptions\NoResultsException
     * @throws \Course\Services\Persistence\Exceptions\QueryException
     */
    public function handle() {
        $userId = $this->getUserModel()->id;
        $roomModel = RoomModel::create($userId);
        Room::addUser($userId);

        if (Room::areThereAreEnoughUsers()) {
            return \Course\Services\Socket\Response::getResponse(
                ResponseEvents::START_GAME,
                '{"ok":true}'
                );
        }
    }
}