<?php

namespace EngincanErgunGG;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\MainLogger;
use onebone\economyapi\EconomyAPI;
use EngincanErgunGG\command\UcusBelgesiCommand;
use EngincanErgunGG\event\EventListener;

class Main extends PluginBase
{

    /**
     * @var Main
     */
    public static $api;

    /**
     * @var EconomyAPI
     */
    public static $eco;

    /**
     * @var array
     */
    public static $players = [];

    /**
     * @return void
     */
    function onEnable(): void
    {
        self::$api = $this;
        self::$eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $this->getServer()->getCommandMap()->register("ucusbelgesi", new UcusBelgesiCommand());
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        MainLogger::$logger->info("Eklenti aktif edildi.");
    }
}
