<?php
//Coding from 

namespace skeelosmalls\TimeLimit;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\utils\TextFormat;


//use pocketmine\event\player\PlayerDeathEvent; //End challenge on Death

class Main extends PluginBase implements Listener {

       public $db;
       public $config;
       //public $api; - future include
         

    public function onEnable() {
         @mkdir($this->getDataFolder());
         $this->getLogger()->info("Time Plugin Has Been Enabled!");
         $this->loadYml();
         $this->db = new \SQLite3($this->getDataFolder() . "TimeLimit.db");
         $this->db->exec("CREATE TABLE IF NOT EXISTS played (id INTEGER PRIMARY KEY AUTOINCREMENT, player TEXT, challenge TEXT, times INTEGER, success INTEGER, fastest TIME, starttime TIME, endtime TIME, active INTEGER);");
         $this->db->exec("CREATE TABLE IF NOT EXISTS challenges (id INTEGER PRIMARY KEY AUTOINCREMENT , name TEXT, val TEXT);");
         $this->getServer()->getPluginManager()->registerEvents($this, $this);
         //$this->api = EconomyAPI::getInstance();
         return true;
    }
    public function onDisable(){
		
            $this->getLogger()->info(TextFormat::DARK_RED . "[TimeLimit] disabled!");
//            $this->getLogger()->info(TextFormat::DARK_RED . "TODO: delete all unfinished!");
	}

    public function onPlayerLogin(PlayerPreLoginEvent $event) {
        $player = $event->getPlayer();
        //$now = time();
//        if($this->TimeList->exists(strtolower($player->getName()))){
//           // if($this->TimeList->get($player->getName()) > $now){
//                  
//                    $this->getLogger()->info(TextFormat::DARK_GREEN . $player->getName()."'s TimeLimit challenges were cleared.");
//                    //$event->setCancelled();
//            //}else{
//                   // $this->TimeList->remove($player->getName());
//                   // $this->TimeList->save();
//            //}
//            return;
//        }
    }
    public function onPlayerLogout(PlayerQuitEvent $event) {
//        $player = $event->getPlayer();
//        $now = time();
//        if($this->TimeList->exists(strtolower($player->getName()))){
//            if($this->TimeList->get($player->getName()) > $now){
//                    $player->sendMessage("You did not complete the last challenge.");
//                    $this->getLogger()->info(TextFormat::DARK_GREEN . $player->getName()." Logged out and did not complete their last challenge.");
//                    $event->setCancelled();
//            }else{
//                    $this->TimeList->remove($player->getName());
//                    $this->TimeList->save();
//            }
//            return;
//        }
    }
    //  ******************
    //  ******************
    //  ON COMMAND
    //  ******************
    //  ******************
    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        switch ($command->getName()) {
            case "timelimit":
                if ($args) {    
//                    $this->getLogger()->info("Boutny Plugin Has Been Set Command!");
                    if ($args[0] === "ch") {  //challenge  <add|del|list>
                        $name = array_shift($args);
                       // $this->getLogger()->info(print_r($args));
//                        $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] chargs[0] = $args[0]");
//                        $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] chargs[1] = $args[1]");
//                        $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] chargs[2] = $args[2]");
//                        $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] chargs[3] = $args[3]");
                        $this->Challenges($sender, $args);
                    } else  {
//                        $name = array_shift($args);
                        $this->Timelimit($sender, $args);                        // challenge Function
                    } 
                    
                } else { 
                        $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] <ch|start|stop|complete|list>");
                        
                 }    
                return true;
            default :
                return false;
            
        }
    }
    //  ******************
    //  ******************
    //   CHALLENGES CLASS
    //  ******************
    //  ******************
    public function Challenges($sender,$args){
       
        if ($args[0] === "add" ) {  // ************ ADD CHALLENGE Function
//            $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] this is add");
            if (isset($args[1]) && isset($args[2]) && isset($args[3])) {  //1 = challenge name | 2= time | 3= commands
                $rm = array_shift($args);
                print_r($args);
                $this->AddChallenge($args);
//                    $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] this is add 1");
            }else{
                $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] ch add [challenge name] [time in MM:SS] [commands]");
            }
            
        }elseif($args[0] === "del" ) {  // ************ DELETE CHALLENGE Function
            if (isset($args[1])) { //2 = challenge name
                $rm = array_shift($args);
                $this->DelChallenge($args);
            }else{
                $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] ch del [challenge name]");
            }
            
        }elseif($args[0] === "list" ) {  // ************ List CHALLENGE Function
            if (!isset($args[1])){
                $page = 1;
            }else{
                $page = $args[1];
            }
            $this->ListChallenge($sender,$page);
//                $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] ch listing challenges:");
            
        }else{
            $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] ch <add|del|list>");
        }
    
    }
    //  ******************
    //  ******************
    //   TIME LIMIT CLASS
    //  ******************
    //  ******************
    public function Timelimit($sender, $args){
         if ($args[0] === "start" ) {  // ************ START Function
            if (isset($args[1]) && isset($args[2])) {
            }else{
                $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] start [player] [challenge name]");
            }
            
        }elseif($args[0] === "stop" ) {  // ************ STOOP Function
           if (isset($args[1]) && isset($args[2])) {

            }else{
                $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] stop [player] [challenge name]");
            }
        }elseif($args[0] === "complete" ) {  // ************ COMPLETE Function
            if (isset($args[1]) && isset($args[2]) && isset($args[3])) {

            }else{
                $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] complete [player] [challenge name] [time in MM:SS]");
            }    
        }elseif($args[0] === "list" ) {    // ************ LIST Function
            if (!isset($args[1])){
                $page = 1;
            }else{
                $page = $args[1];
            }
                $this->ListTimeLimit($sender,$page);
                $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] listing players in challenges");
            
        }else{
            $this->getLogger()->info(TextFormat::DARK_GREEN . "[timelimit] <start|stop|list|complete>");
        }
    
    }
    //  ******************
    //  ******************
    //   CHALLENGES
    //      ADD
    //  ******************
    //  ******************
     public function AddChallenge($args) {
            $oldChallenges = $this->getConfig()->get("challenges");
            $this->getLogger()->info("addchallenge Function");
//            print_r($oldChallenges);
//            $keys = array_keys($args, '\"');
//            print_r($keys);
            $name = array_shift($args);
            
            $time = array_shift($args);
            $string1 = "";
            foreach ($args as $string){ $string1 .= $string . " ";}
            $trim_string = trim($string1);
            $newChallenges = ['name' => $name,
            'time' => $time,
            'commands' => array($trim_string)];
            $oldChallenges[] = $newChallenges;
            $this->getConfig()->setNested("challenges",$oldChallenges);
            $this->saveConfig();
                
    }
    //  ******************
    //  ******************
    //   CHALLENGES
    //      Delete
    //  ******************
    //  ******************
    public function DelChallenge($args) {
            $oldChallenges = $this->getConfig()->get("challenges");
            $challengeCount = count($oldChallenges);
            print_r($oldChallenges);
            $name = array_shift($args);
            $key = array_search($name, array_column($oldChallenges, 'name'));
            if ($key){
                $this->getLogger()->info(TextFormat::DARK_RED . "Deleting $name Challenge ");
                $newChallenges = array_splice($oldChallenges, $key - 1, 1);
                $this->getConfig()->setNested("challenges",$newChallenges);
                print_r($newChallenges);
                $this->saveConfig();
            }else {
                $this->getLogger()->info(TextFormat::YELLOW . "Challenge \"$name\" Not Found ");
            }
                
    }   
        
        
    //  ******************
    //  ******************
    //     CHALLENGES
    //       List
    //  ******************
    //  ******************
        public function ListChallenge($sender,$page){
            $listChallenges = $this->getConfig()->get("challenges");
            $listCount = count($listChallenges);
//            print_r($listCount);
            $page = $page*1;
            $sender->sendMessage("---- Challenge List ----");
            $startnum = $page * 5;
            $endnum = $startnum - 5;
            
            if ($listCount < $endnum){
//                if ($startnum > $listCount){
                  $endnum = 0;
                  $startnum = $listCount - 1;
//                }
//                $endnum = $listcount;
            }
            for ($x = $endnum; $x<$startnum; $x++){
                $xx = $x + 1;
//            $sqlr = $this->db->query("SELECT * FROM played WHERE active=1 ORDER BY `id` DESC LIMIT $x,1");
//            $eslf = $sqlr->fetchArray(SQLITE3_ASSOC);
                
                if($x == $listCount){
                    $sender->sendMessage("------- Finished --------");
                    break;
                } else {
                    $sender->sendMessage("$x");
                    $sender->sendMessage("#".$xx."-".$listChallenges[$x]['name']." -> ". $listChallenges[$x]['time']);
                   
                }
            }
            
//            $this->api->addMoney ( $sender->getName(), $eslf['amount'] );
            $sender->sendMessage("-------Page $page--------");
            
        }
              
                      
                              
                                              
    //  ******************
    //  ******************
    //   List TIME LIMIT
    //  ******************
    //  ******************
        public function ListTimeLimit($sender,$page){
            $page = $page*1;
            $sender->sendMessage("---- Challengers ----");
            $startnum = $page * 5;
            $endnum = $startnum - 5;
            for ($x = $endnum; $x<$startnum; $x++){
            $xx = $x + 1;
            $sqlr = $this->db->query("SELECT * FROM played WHERE active=1 ORDER BY `id` DESC LIMIT $x,1");
            $eslf = $sqlr->fetchArray(SQLITE3_ASSOC);
            $sender->sendMessage("#".$xx."-".$eslf['player']." -> ". $eslf['challenge']);
            }
            
//            $this->api->addMoney ( $sender->getName(), $eslf['amount'] );
            $sender->sendMessage("-------Page $page--------");
        }

    //  ******************
    //  ******************
    //   LOAD  YML FILE
    //  ******************
    //  ******************
        public function loadYml(){
        @mkdir($this->getServer()->getDataPath() . "/plugins/TimeLimit/");
        $mkchallenges = array('name'=>"Sample Challenge",
            'time'=>'00:30',
            'commands'=>array());
            $this->config = (new Config($this->getServer()->getDataPath() . "/plugins/TimeLimit/" . "config.yml", Config::YAML ,array(
            'version'=>"1.0.1",
            'challenges' => array( $mkchallenges ),
            )))->getAll();
        return true;
    }
}  
//    public function onCommand(CommandSender $sender, Command $command, $label, array $params) {
//        switch ($command->getName()) {
//            case "timelimit":
//                $sub = array_shift($params);
//                switch ($sub) {
//                    case "add":
//                        $player = array_shift($params);
//                        $after = array_shift($params);
//                        $reason = implode(" ", $params);
//                        if (trim($player) === "" or !is_numeric($after)) {
//                            $sender->sendMessage("[TimeLimit] Usage: /timelimit add <player> <time> <challenge>");
//                            break;
//                        }
//                        $after = round($after, 2);
//                        $secAfter = $after * 1200;
//
//                        $due = $secAfter + time();
//
//                        $this->TimeList->set(strtolower($player), $due );
//                        $this->TimeList->save();
//
//                        $sender->sendMessage("[TimeLimit] $player has $after Minute(s) to complete this Challenge.");
//                        //$this->getServer()->getScheduler()->scheduleDelayedTask(new TimeLimit($this), $secAfter);
//
//                        if (($player = $this->getServer()->getPlayer($player)) instanceof Player) {
//                            //$DelayTask = $player->kill("You didn't complete the challenge");
//                           $this->getServer()->getScheduler()->scheduleDelayedTask(new TimeLimit($this), $secAfter);
//                            $this->getLogger()->info(TextFormat::DARK_GREEN . "$player accepted the $reason challenge!");
//                        }
//                        break;
//                    case "remove":
//                    case "pardon":
//                        $player = array_shift($params);
//
//
//                        if (trim($player) === "") {
//                            $sender->sendMessage("[TimeLimit] Usage: /timelimit remove <player>");
//                            break;
//                        }
//
//                        if (!$this->TimeList->exists($player)) {
//                            $sender->sendMessage("[TimeLimit] \"$player\" is not in the challenge.");
//                            break;
//                        }
//
//                        $this->TimeList->remove($player);
//                        $this->TimeList->save();
//                        $sender->sendMessage("[TimeLimit] \"$player\" has been removed from the challenge.");
//                        break;
//                    case "complete":
//                        $player = array_shift($params);
//
//
//                        if (trim($player) === "") {
//                            $sender->sendMessage("[TimeLimit] Usage: /timelimit complete <player>");
//                            break;
//                        }
//
//                        if (!$this->TimeList->exists($player)) {
//                            $sender->sendMessage("[TimeLimit] \"$player\" is not in the challenge.");
//                            break;
//                        }
//
//                        $this->TimeList->remove($player);
//                        $this->TimeList->save();
//                        $sender->sendMessage("[TimeLimit] \"$player\" has completed the challenge.");
//                        break;
//                    case "list":
//                        $list = $this->TimeList->getAll();
//                        $output = "TimeLimit list : \n";
//                        foreach ($list as $key => $due) {
//                            $output .= $key . ", ";
//                        }
//                        $output = substr($output, 0, -2);
//                        $sender->sendMessage($output);
//                        break;
//                    default:
//                        $sender->sendMessage("[TimeLimit] Usage: " . $command->getUsage());
//                }
//                break;
//        }
//        return true;
//    }
//
//}
