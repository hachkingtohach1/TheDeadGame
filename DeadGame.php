<?php
  
class Main {
    
    public function getGame() {
        $game = new Game;
        return $game;
    }

    public function sendMessage($msg) {
        echo "\n".$msg;
    }

    public function openGame() {
        $this->getGame()->loadingGame();
    }
}

class Game {

    public $language = "English";
    public $decks = [];
    public $hand_you = 10;
    public $hand_robin = 10;

    public function getAlert() {
        $alert = new Alert;
        return $alert;
    }

    public function loadingGame() {
        sleep(5);
        $this->chooseLanguage();
    }

    public function chooseLanguage() {
        $this->getAlert()->getAlert($this->language, "MESSAGE_CHOOSE_LANG");
        fscanf(STDIN, "%s", $lang);
        $this->language = $lang;
        $this->mainGame();
    }

    public function returnTypeCommands() {
        fscanf(STDIN, "%s", $type);
    }

    public function commandsMainGame($type) {
        if($type == ".start") {
            $this->startGame();
        }
        if($type == ".lang") {
            $this->chooseLanguage();
        } 
        if($type == ".info") {
            $this->getAlert()->getAlert($this->language, "INFO");
            sleep(1);
            $this->mainGame();
        } else {
            $this->returnTypeCommands();
        }
    }

    public function commandsInGame($type) {
        if($type == ".add") {
            $this->addCards();
        }
        if($type == ".done") {
            $this->checkCards();
        }
    }

    public function mainGame() {
        $this->getAlert()->getAlert($this->language, "MESSAGE_MAIN_GAME");
        fscanf(STDIN, "%s", $type);
        $this->commandsMainGame($type);
    }

    public function startGame() {
        sleep(1);
        $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_1"); 
        sleep(2);
        $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_2");
        sleep(2);
        $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_YOU_1"); 
        sleep(2);
        $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_3"); 
        sleep(2); 
        $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_4"); 
        sleep(2);
        $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_5");
        sleep(2);
        $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_6");
        $this->getDeckCards();          
    }

    public function endGame() {
        echo "\n"."This is beta game";
    }

    public function checkCards() {
        $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_9");
        sleep(4);
        if($this->decks["YOU"] > 20) {
            $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_10");
            $this->cutFinger("YOU");
            return $this->resetData();
        }
        if($this->decks["ROBIN"] > 20) {
            $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_8");
            $this->cutFinger("ROBIN");
            return $this->resetData();
        }
        if($this->decks["YOU"] < $this->decks["ROBIN"]) {
            $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_7");
            $this->cutFinger("YOU");
            return $this->resetData();
        }
        if($this->decks["YOU"] > $this->decks["ROBIN"]) {
            $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_8");
            $this->cutFinger("ROBIN");
            return $this->resetData();
        }
        if($this->decks["YOU"] == $this->decks["ROBIN"]) {
            return $this->resetData();
        }
    }

    public function checkHands() {
        if($this->hand_you == 0) {
            $this->getAlert()->getAlert($this->language, "MESSAGE_LOSE");
            return $this->endGame();
        }
        if($this->hand_robin == 0) {
            $this->getAlert()->getAlert($this->language, "MESSAGE_WON");
            return $this->endGame();
        }
    }

    public function resetData() {
        $this->deck = [];       
        $this->getAlert()->getAlert($this->language, "MESSAGE_SAY_JOHN_11");
        sleep(2);
        $this->getDeckCards();
    }

    public function cutFinger($name) {
        if($name == "YOU") {
            $hand = $this->hand_you - 1;
            $this->hand_you = $hand;
        }
        if($name == "ROBIN") {
            $hand = $this->hand_robin - 1;
            $this->hand_robin = $hand;
        }
    }

    public function getDeckCards() {
        $this->checkHands();
        $this->decks["YOU"] = rand(10,20);
        $this->decks["ROBIN"] = rand(10,20);
        echo "\n\nYOU: ".$this->decks["YOU"];
        echo "\nROBIN: ".$this->decks["ROBIN"];
        $this->getAlert()->getAlert($this->language, "MESSAGE_ADD_CARD");
        fscanf(STDIN, "%s", $type);
        $this->commandsInGame($type);
    }

    public function addCards() {
        $add = $this->decks["YOU"] + rand(3,10);
        $this->decks["YOU"] = $add;
        echo "\n\nYOU: ".$this->decks["YOU"];
        echo "\nROBIN: ".$this->decks["ROBIN"];
        $this->getAlert()->getAlert($this->language, "MESSAGE_ADD_CARD");
        fscanf(STDIN, "%s", $type);
        $this->commandsInGame($type);
    }
}

class Alert {

    public $msg;

    public function getMain() {
        $main = new Main;
        return $main;
    }

    public function getAlert($language, $msg) {
        if($language == "English") {
            $alert = [
                "MESSAGE_START" => "Welcome to DeadGame!\nStarting in 5s...",
                "MESSAGE_CHOOSE_LANG" => "Choose language:\n- Vietnamese\n- English\nType language: ",
                "MESSAGE_MAIN_GAME" => "You are in the lobby of type:\n.info to see about the game\n.lang to choose language.\n.start to start the game.",
                "MESSAGE_ADD_CARD" => "Type .add to add cards or .done to end in turn!",
                // GAME 
                "MESSAGE_SAY_JOHN_1" => "John > Welcome to my world!",
                "MESSAGE_SAY_JOHN_2" => "John > I hope you got your body!",
                "MESSAGE_SAY_JOHN_3" => "John > Be quiet and wish you play fun!",
                "MESSAGE_SAY_JOHN_4" => "John > Now I'm going to play you a few cards!",
                "MESSAGE_SAY_JOHN_5" => "John > If the number of buttons on your hand\na maximum of 20/20 if you do, you know\n Lose 1 finger hahaha!",
                "MESSAGE_SAY_JOHN_6" => "John > You have the right to add more cards.",
                "MESSAGE_SAY_JOHN_7" => "John > You lose 1 finger.!",
                "MESSAGE_SAY_JOHN_8" => "John > Wow, that's the next turn!\nThe flesh loses 1 finger!",
                "MESSAGE_SAY_JOHN_9" => "John > See what!",
                "MESSAGE_SAY_JOHN_10" => "John > Oh, you're dead:) As the number of eyebrows on 20",
                "MESSAGE_SAY_JOHN_11" => "John > Next page!",
                "MESSAGE_SAY_YOU_1" => "You > Why are you here, let me go!",

                "MESSAGE_LOSE" => "You lost! I will kill you now!",
                "MESSAGE_WON" => "Well, that bastard you won!",

                "INFO" => "I am Nam and I am a PHP coder"."\nI am the author of this little game!"
            ];
            $this->getMain()->sendMessage($alert[$msg]);
        }
        if($language == "Vietnamese") {
            $alert = [
                "MESSAGE_START" => "Chào mừng bạn đến DeadGame\nBắt đầu trong 5s...",
                "MESSAGE_CHOOSE_LANG" => "Chọn ngôn ngữ:\n- Vietnamese\n- English\nĐiền ngôn ngữ cần: ",              
                "MESSAGE_MAIN_GAME" => "Bạn đang ở sảnh ấn:\n.info để xem chi tiết về tựa game\n.lang để chọn ngôn ngữ.\n.start để bắt đầu.",
                "MESSAGE_ADD_CARD" => "thêm thẻ ấn .add hay ấn .done để kết thúc lượt!",
                // GAME 
                "MESSAGE_SAY_JOHN_1" => "John > chào mừng mày đã đến thế giới của tao!",
                "MESSAGE_SAY_JOHN_2" => "John > tao mong là số mày giữ được cái thân của mày!",
                "MESSAGE_SAY_JOHN_3" => "John > yên lặng nào và chúc mày chơi vui vẻ!",
                "MESSAGE_SAY_JOHN_4" => "John > giờ tao sẽ phát mày vài lá bài với các số!",
                "MESSAGE_SAY_JOHN_5" => "John > nếu số nút trên tay mày nhiều hơn\ntối đa là 20/20 nếu quá thì mày hiểu rồi đấy\nmất 1 ngón tay hahaha!",
                "MESSAGE_SAY_JOHN_6" => "John > mày có quyền thêm nhiều lá khác đấy",
                "MESSAGE_SAY_JOHN_7" => "John > chà mày mất 1 ngón tay rồi!",
                "MESSAGE_SAY_JOHN_8" => "John > chà mày rất hên đấy được rồi lượt tiếp theo nào!\ncái xác mất 1 ngón tay!",
                "MESSAGE_SAY_JOHN_9" => "John > nào xem nào!",
                "MESSAGE_SAY_JOHN_10" => "John > ối chà mày chết chắc rồi :) vì số nút mày trên 20",
                "MESSAGE_SAY_JOHN_11" => "John > lượt tiếp nào !",
                "MESSAGE_SAY_YOU_1" => "You > sao tôi lại ở đây, mau thả tôi ra!",

                "MESSAGE_LOSE" => "Mày thua rồi! đáng tiếng giờ tao sẽ giết mày!",
                "MESSAGE_WON" => "Chà thằng chó mày đã thắng không thể nào!",

                "INFO" => "Tôi là Nam và tôi là một coder PHP"."\nTôi là tác giả cho tựa game nhỏ này!"
            ];
            $this->getMain()->sendMessage($alert[$msg]);
        }
    }
}

$main = new Main;
$main->openGame();
?>