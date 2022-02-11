<?php

namespace EngincanErgunGG\task;

use EngincanErgunGG\Main;
use pocketmine\Player;
use pocketmine\scheduler\Task;

class UcusBelgesiTask extends Task
{

    /**
     * @var int
     */
    public $tick;

    /**
     * @var Player
     */
    public $e;

    function __construct(Player $e, int $tick)
    {
        $this->tick = $tick;
        $this->e = $e;
    }

    function onRun(int $currentTick)
    {
        $e = $this->e;
        if ($e instanceof Player)
        {
            $this->tick--;
            $date = gmdate("i:s", $this->tick);
            $exp = explode(":", $date);
            if ($exp[0] === 00)
            {
                $format = "§f" . $exp[1] . " §6saniye";
            }else{
                $format = "§f" . $exp[0] . " §6dakika §f" . $exp[1] . " §6saniye";
            }
            if (!$e->getAllowFlight())
            {
                $e->setAllowFlight(true);
            }
            $e->sendPopup("§6Kalan Süre: " . $format);
            if ($this->tick === 0)
            {
                $e->setAllowFlight(false);
                if ($e->isFlying()) $e->setFlying(false);
                unset(Main::$players[$e->getName()]);
                $e->sendPopup("§6Uçuş Belgen bitti.");
                Main::$api->getScheduler()->cancelTask($this->getTaskId());
            }
        }else{
            Main::$api->getScheduler()->cancelTask($this->getTaskId());
        }
    }
}
