<?php

declare(strict_types = 1);

namespace core\command\types;

use core\command\utils\Command;
use core\CrypticPlayer;
use core\translation\Translation;
use core\translation\TranslationException;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class FreezeCommand extends Command {

    /**
     * FreezeCommand constructor.
     */
    public function __construct() {
        parent::__construct("freeze", "Freeze and unfreeze player.", "/freeze <on/off> <player>");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     *
     * @throws TranslationException
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if(isset($args[0])) {
            if(!$sender->isOp()) {
                if(!$sender->hasPermission("permission.mod")) {
                    $sender->sendMessage(Translation::getMessage("noPermission"));
                    return;
                }
            }
            switch($args[0]) {
                case "on":
                    if(!isset($args[1])) {
                        $sender->sendMessage(Translation::getMessage("usageMessage", [
                            "usage" => $this->getUsage()
                        ]));
                        return;
                    }
                    $player = $this->getCore()->getServer()->getPlayer($args[1]);
                    if(!$player instanceof CrypticPlayer) {
                        $sender->sendMessage(Translation::getMessage("invalidPlayer"));
                        return;
                    }
                    $player->setImmobile();
                    $player->sendMessage(Translation::getMessage("freezePlayer"));
                    $sender->sendMessage(Translation::getMessage("freezeSender", [
                        "player" => TextFormat::GREEN . $player->getName()
                    ]));
                    break;
                case "off":
                    if(!isset($args[1])) {
                        $sender->sendMessage(Translation::getMessage("usageMessage", [
                            "usage" => $this->getUsage()
                        ]));
                        return;
                    }
                    $player = $this->getCore()->getServer()->getPlayer($args[1]);
                    if(!$player instanceof CrypticPlayer) {
                        $sender->sendMessage(Translation::getMessage("invalidPlayer"));
                        return;
                    }
                    $player->setImmobile(false);
                    $player->sendMessage(Translation::getMessage("unfreezePlayer"));
                    $sender->sendMessage(Translation::getMessage("unfreezeSender", [
                        "player" => TextFormat::GREEN . $player->getName()
                    ]));
                    break;
            }
            return;
        }
        $sender->sendMessage(Translation::getMessage("usageMessage", [
            "usage" => $this->getUsage()
        ]));
        return;
    }
}