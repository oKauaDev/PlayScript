<?php

use pocketmine\player\Player;

$p = $this->getServer()->getPlayerByPrefix("LadinoXx");
if (!$p instanceof Player) {
    print_r("player not found\n");
}else{
    $p->sendMessage("player found");
}