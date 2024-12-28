<?php

namespace VsrStudio\loadingscreen\task;

use pocketmine\network\mcpe\protocol\StopSoundPacket;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;

/**
 * Class RemoveSoundTask
 * @package spicearth\loadingscreen\task
 */
class RemoveSoundTask extends Task
{
    /** @var Player  */
    private $player;

    /**
     * RemoveSoundTask constructor.
     */
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick): void
    {
        $player = $this->player;
        $pk = new StopSoundPacket();
        $pk->soundName = "portal.travel";
        $pk->stopAll = true;
        
        $player->sendDataPacket($pk);
    }
}
