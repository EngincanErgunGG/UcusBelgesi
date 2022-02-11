<?php

namespace EngincanErgunGG\form;

define("FIYAT", 7500);

use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use dktapps\pmforms\element\Label;
use EngincanErgunGG\Main;
use pocketmine\item\Item;
use pocketmine\Player;

class UcusBelgesiForm extends CustomForm
{

    function __construct(Player $e)
    {
        parent::__construct(
            "Uçuş Belgesi",
            [
                new Label("info", "§6Dakika başına §f7500 TL\n§4§lNOT:§r §cEn fazla 30 dakikalık oluşturabilirsiniz.\n"),
                new Input("minute", "Dakika Gir:", "§7Örnek; 5")
            ],

            function (Player $e, CustomFormResponse $response): void
            {
                $minute = intval($response->getString("minute"));
                if ($minute !== null)
                {
                    if (is_numeric($minute) and $minute > 0)
                    {
                        if ($minute > 30)
                        {
                            $e->sendMessage("§cEn fazla 30 dakikalık uçuş belgesi oluşturabilirsiniz.");
                            return;
                        }
                        if (Main::$eco->myMoney($e) >= $minute*FIYAT)
                        {
                            $item = Item::get(339, 0, 1);
                            $item->setCustomName("§6Uçuş Belgesi");
                            if ($e->getInventory()->canAddItem($item))
                            {
                                $item->getNamedTag()->setInt("minute", $minute);
                                $e->getInventory()->addItem($item);
                                Main::$eco->reduceMoney($e, $minute*FIYAT);
                                $e->sendMessage("§f" . $minute . " §6Dakikalık uçuş belgesi satın alındı.");
                            }else{
                                $e->sendMessage("§cEnvanterinde yer yok.");
                            }
                        }else{
                            $e->sendMessage("§cParan yetersiz.");
                        }
                    }else{
                        $e->sendMessage("§cLütfen sayısal bir değer giriniz.");
                    }
                }
            }
        );
    }
}
