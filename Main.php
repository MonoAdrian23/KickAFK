<?php

declare(strict_types=1);

namespace MonoAdrian23\KickAFK;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    /** @var array  */
    public static $times = [];

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->getScheduler()->scheduleRepeatingTask(new AfkTask($this), 20 * 60);
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        self::$times[$event->getPlayer()->getName()] = time();
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        unset(self::$times[$event->getPlayer()->getName()]);
    }

    public function onMove(PlayerMoveEvent $event): void
    {
        if($event->getFrom() === $event->getTo()) return;

        self::$times[$event->getPlayer()->getName()] = time();
    }

}
