<?php

declare(strict_types=1);

namespace LadinoXx\PlayScript;

use pocketmine\plugin\PluginBase;
use LadinoXx\PlayScript\PlayScriptCommand;

class Main extends PluginBase{

    /**
     * @return void
     */
    public function onEnable() : void
    {
        @mkdir($this->getDataFolder() . "scripts/");
        $this->saveResource("scripts/base.php");
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("script", new PlayScriptCommand($this));
        foreach($this->getConfig()->get("run-scripts") as $filename) {
            if (!file_exists($this->getDataFolder() . "scripts/" . $filename)) {
                $this->getLogger()->warning("§ciFle " . $filename . " does not exist");
            }else{
                $this->executeScript($filename);
            }
        }
    }

    /**
     * @param string $path
     * @return void
     */
    public function executeScript(string $path) : void
    {
        include($this->getDataFolder() . "scripts/" . $path);
    }
    
    /**
    * @param int $size
    * @return string|null
	*/
	public function convertBytes(int $size): ?string
	{
  	  $prefix = ["B", "KB", "MB"]; // Why not up to GB, TB and so on?, because in my opinion for Exec files, only small files, For large files, it's better to make a plugin
   	 $format = $size > 0 ? floor(log($size, 1024)) : 0;
   	 if(!isset($prefix[$format])){
   		return null;
   	 }
   
    	return number_format($size / pow(1024, $format), 2, ".", ",") . " " . $prefix[$format];
	}
}
