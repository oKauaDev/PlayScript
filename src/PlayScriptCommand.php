<?php

namespace LadinoXx\PlayScript;

use FilesystemIterator;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use LadinoXx\PlayScript\Main;

class PlayScriptCommand extends Command {

    /**
     * @var Main
     */
    public Main $plugin;

    /**
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("playscript", "run a script in php", "§cUsage : /playscript <string: filename|string: list>", ["ps"]);
        $this->setPermission("playscript.command");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) return;
        if (!isset($args[0])) {
            $sender->sendMessage("§cUsage : /playscript <string: filename|string: list>");
            return;
        }
        if ($args[0] == "list") {
            $message = "§cFile List:";
            foreach(new FilesystemIterator($this->plugin->getDataFolder() . "scripts") as $file) {
            	if($file->getExtension() === "php"){ // Check only for PHP
					$filesize = $this->plugin->convertBytes($file->getSize());
					// Check for file size only B, KB, MB
					if($filesize !== null){
                		$message .= "\n§c - " . $file->getFilename() . " §a(" . $filesize . ")";
                	}
                }
            }
            $sender->sendMessage($message);
            return;
        }
        if (!file_exists($this->plugin->getDataFolder() . "scripts/" . $args[0])) {
            $sender->sendMessage("§cFile " . $args[0] . " Does not found in Path Scripts!");
            return;
        }
        
        if(!strpos($args[0], ".php")){
        	$sender->sendMessage("§cPlease input PHP File name!");
        	return;
        }
        
        $fsize = $this->plugin->convertBytes(filesize($this->plugin->getDataFolder() . "scripts/" . $args[0]));
		// Check for file size only B, KB, MB
		if($fsize === null){
			$sender->sendMessage("§cFile size is too bigger!, Only B, KB, MB Accepted!");
			return;
		}
		
        $this->plugin->executeScript($args[0]);
    }
}