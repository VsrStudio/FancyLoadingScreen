<?php

namespace VsrStudio\loadingscreen;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\world\World;
use pocketmine\world\WorldManager;
use VsrStudio\loadingscreen\command\LoadingScreenCommand;
use muqsit\dimensionportals\DimensionPortalManager;
use muqsit\dimensionportals\DimensionPortal;

/**
 * Class LoadingScreen
 * @package VsrStudio\loadingscreen
 */
class LoadingScreen extends PluginBase
{
    /** @var LoadingScreen */
    private static $instance;

    /**
     * @return void
     */
    public function onEnable(): void
  {
        $this->getServer()->getCommandMap()->register("transfer", new LoadingScreenCommand("transfer", "Transfer you to another world with fancy Loading Screen"));

        $worldManager = $this->getServer()->getWorldManager();
        $worldName = "transfer";
        $worldPath = $this->getServer()->getDataPath() . "/worlds/" . $worldName;

        if (!file_exists($worldPath)) {
            $worldManager->generateWorld($worldName, World::GENERATOR_NORMAL);
        } else {
            if (!$worldManager->isWorldLoaded($worldName)) {
                $worldManager->loadWorld($worldName);
            }
        }

        $levels = scandir($this->getServer()->getDataPath() . "/worlds/");
        foreach ($levels as $name) {
            if (in_array($name, [".", ".."])) {
                continue;
            }
            if ($worldManager->isWorldLoaded($name)) {
                $this->getServer()->getLogger()->notice($name . " is already loaded");
            } else {
                $worldManager->loadWorld($name);
            }
        }

        self::$instance = $this;
    }

    /**
     * @param Player $player
     * @param string $worldName
     * @return void
     */
    public function teleportPlayerToWorld(Player $player, string $worldName): void
    {
        $worldManager = $this->getServer()->getWorldManager();
        if ($worldManager->isWorldLoaded($worldName)) {
            $world = $worldManager->getWorldByName($worldName);
            $player->teleport($world->getSpawnLocation());
            $this->getLogger()->info("Player {$player->getName()} has been teleported to world {$worldName}.");
        } else {
            $player->sendMessage("World {$worldName} is not loaded!");
        }
    }

    /**
     * @return LoadingScreen
     */
    public static function getInstance(): LoadingScreen
    {
        return self::$instance;
    }
}
