<?php

namespace EngincanErgunGG\command;

use EngincanErgunGG\form\UcusBelgesiForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class UcusBelgesiCommand extends Command
{

    function __construct()
    {
        parent::__construct(
            "ucusbelgesi",
            "Para ile uçmak mı? Dene ve gör!",
            "/ucusbelgesi",
            ["ub"]
        );
    }

    function execute(CommandSender $e, string $lbl, array $args)
    {
        if ($e instanceof Player)
        {
            $e->sendForm(new UcusBelgesiForm($e));
        }else{
            $e->sendMessage("§cBu komut oyunda kullanılabilir.");
        }
    }
}
