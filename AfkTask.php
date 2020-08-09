<?php

declare(strict_types=1);

namespace MonoAdrian23\KickAFK;

use pocketmine\scheduler\Task;

class AfkTask extends Task {

    private $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick)
    {
        $afk = $this->plugin->getConfig()->getNested("time");
        foreach (Main::$times as $player => $time){
            if(time() - $time >= $afk){
                $player = $this->plugin->getServer()->getPlayer($player);
                if($player){
                    $player->kick($this->plugin->getConfig()->getNested("kick_message"), false);
                }
            }
        }
    }
}