<?php

namespace VsrStudio\loadingscreen\task;

use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use VsrStudio\loadingscreen\LoadingScreen;

/**
 * Class SendScreenTask
 * @package VsrStudio\loadingscreen\task
 */
class SendScreenTask extends Task
{
    /** @var Player  */
    private $player;

    /** @var string  */
    private $args;

    /**
     * SendScreenTask constructor.
     * @param Player $player
     * @param string $args
     */
    public function __construct(Player $player, string $args)
    {
        $this->player = $player;
        $this->args = $args;
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick): void
    {
        $args = $this->args;
        $player = $this->player;

        $level = LoadingScreen::getInstance()->getServer()->getWorldManager()->getWorldByName($args);

        if ($level !== null) {
            $safeSpawn = $level->getSafeSpawn();
            $player->teleport($safeSpawn);
        } else {
            $player->sendMessage("World with name $args does not exist.");
        }
    }
}
