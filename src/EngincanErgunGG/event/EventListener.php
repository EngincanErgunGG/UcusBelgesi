<?php

namespace EngincanErgunGG\event;

use EngincanErgunGG\task\UcusBelgesiTask;
use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use EngincanErgunGG\Main;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener
{

    function onInteract(PlayerInteractEvent $event)
    {
        $e = $event->getPlayer();
        $inv = $e->getInventory();
        $hand = $inv->getItemInHand();
        if ($hand->hasCustomName() and $hand->getCustomName() === "§6Uçuş Belgesi" and $hand->getID() === 339)
        {
            if ($hand->getNamedTag()->hasTag("minute"))
            {
                if ($event->getBlock()->getID() === Block::ITEM_FRAME_BLOCK) {
                    $event->setCancelled();
                    return;
                }
                if (isset(Main::$players[$e->getName()]))
                {
                    $event->setCancelled();
                    $e->sendMessage("§cZaten uçuş belgesi kullanmışsın. Lütfen bitmesini bekle.");
                    return;
                }
                $minute = $hand->getNamedTag()->getInt("minute");
                if ($hand->getCount() > 1)
                {
                    $minute = $hand->getCount() * $minute;
                }
                $e->getInventory()->remove($hand);
                $tick = 60*$minute;
                $e->sendMessage("§f" . $minute . " §6dakikalık Uçuş Belgesi kullanıldı.");
                Main::$players[$e->getName()] = true;
                Main::$api->getScheduler()->scheduleRepeatingTask(new UcusBelgesiTask($e, $tick), 20*1);
            }
        }
    }

    function onQuit(PlayerQuitEvent $event)
    {
        $e = $event->getPlayer();
        if (isset(Main::$players[$e->getName()])) unset(Main::$players[$e->getName()]);
        $e->sendPopup(" ");
    }
}
