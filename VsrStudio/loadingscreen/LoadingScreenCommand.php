<?php

namespace VsrStudio\loadingscreen\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use VsrStudio\loadingscreen\Language;
use VsrStudio\loadingscreen\LoadingScreen;
use VsrStudio\loadingscreen\task\SendScreenTask;
use VsrStudio\loadingscreen\task\RemoveSoundTask;

/**
 * Class LoadingScreenCommand
 * @package VsrStudio\loadingscreen\command
 */
class LoadingScreenCommand extends Command
{

    /** @var Language  */
    private $language;

    /**
     * LoadingScreenCommand constructor.
     * @param string $name
     * @param string $description
     * @param string|null $usageMessage
     * @param array $aliases
     */
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        $this->language = new Language();
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("transfer.world.command");
        $this->setPermissionMessage(TextFormat::RED . $this->language->translateLanguage(6));
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return mixed|void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $language = $this->language;
        
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . $language->translateLanguage(1));
            return;
        }

        if (!$this->testPermission($sender)) {
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage(TextFormat::RED . $language->translateLanguage(2));
            return;
        }

        // Menggunakan WorldManager untuk mendapatkan level
        $worldManager = LoadingScreen::getInstance()->getServer()->getWorldManager();
        $worldList = scandir(LoadingScreen::getInstance()->getServer()->getDataPath() . "/worlds");

        if (!in_array($args[0], $worldList)) {
            $sender->sendMessage(TextFormat::RED . $language->translateLanguage(3));
            return;
        }

        $level = $worldManager->getWorldByName($args[0]);
        if ($level === null) {
            $sender->sendMessage(TextFormat::RED . $language->translateLanguage(4));
            return;
        }

        $transferLevel = $worldManager->getWorldByName("transfer");
        if ($transferLevel === null) {
            $sender->sendMessage(TextFormat::RED . $language->translateLanguage(5));
            return;
        }

        if ($sender->getWorld()->getName() !== $args[0]) {
            $sender->teleport($transferLevel->getSafeSpawn());
            LoadingScreen::getInstance()->getScheduler()->scheduleDelayedTask(new SendScreenTask($sender, $args[0]), 20);
            LoadingScreen::getInstance()->getScheduler()->scheduleDelayedTask(new RemoveSoundTask($sender), 25);
        } else {
            $sender->teleport($level->getSafeSpawn());
        }
    }
}
