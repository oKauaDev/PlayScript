<?php

use pocketmine\player\Player;

$p = $this->getServer()->getPlayerByPrefix("LadinoXx");
if (!$p instanceof Player) {
    print_r("no player\n");
}else{
    $p->sendMessage("...");
}