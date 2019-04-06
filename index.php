<?php

class Board
{
    private $board = array();
        
    public function __construct($files, $columns)
    {
        for($i = 0; $i < $files; $i++){
            $this->board[$i] = array();
            for($j = 0; $j < $columns; $j++){
                $this->board[$i][$j] = '-';
            }
        }
         
    }
    public function draw($positionX, $positionY, $marca)
    {
        $this->board[$positionX][$positionY] = $marca;
    }
    public function giveMePosition($positionX, $positionY)
    {
        return $this->board[$positionX][$positionY];
    }
    public function getBoard()
    {
        return $this->board;
    }
    public function show()
    {
        echo '<br>';
        foreach($this->board as $file){
            foreach($file as $column){
                echo $column . ' ';
            }
            echo '<br>';
        }
        echo '<br>';
    }
    public function isFull()
    {
        foreach($this->board as $file){
            foreach($file as $column){
                if($column == '-'){
                    return false;
                }
            }
            
        }
        return true;
    }
    
}

class Player
{
    private $name;
    private $mark;

    public function __construct($name, $mark)
    {
        $this->name = $name;
        $this->mark = $mark;
    }

    public function getName(){
        return $this->name;
    }
    public function getMark(){
        return $this->mark;
    }
}

class TatetiTwoPlayers
{
    private $players = [];
    private $board;
    private $activePlayer;

    public function __construct(Player $player1, Player $player2, Board $board)
    {
        $this->players[] = $player1;
        $this->players[] = $player2;
        $this->board = $board;
        $this->activePlayer = $this->players[0];
        
    }
    public function play($x, $y)
    {
        if($this->board->giveMePosition($x, $y) == '-'){
            $this->board->draw($x, $y, $this->activePlayer->getMark());
            $this->board->show();
            //$this->board->isFull();
            self::areWinner();
            if($this->activePlayer == $this->players[0]){
                $this->activePlayer = $this->players[1];
            }else{
                $this->activePlayer = $this->players[0];
            }
        }elseif($this->board->giveMePosition($x, $y) == null){
            echo 'Posición inexistente <br>'; 
        }else{
            echo 'Casillero ocupado <br>';
        }
       

    }
    public function areWinner()
    {
        if($this->board->isFull()){
            echo 'Empate';
            self::stop();
        }
        $array = $this->board->getBoard();
        foreach($array as $v){
            if($v[0] != '-' && $v[0] == $v[1] && $v[0] == $v[2]){
                echo 'Ganó ' . $this->activePlayer->getName() . '<br>';
                self::stop();
            }
        }
        if($array[0][0] != '-' && $array[0][0] == $array[1][0] && $array[0][0] == $array[2][0]){
            echo 'Ganó ' . $this->activePlayer->getName() . '<br>';
                self::stop();
        }
        if($array[0][1] != '-' && $array[0][1] == $array[1][1] && $array[0][1] == $array[2][1]){
            echo 'Ganó ' . $this->activePlayer->getName() . '<br>';
                self::stop();
        }
        if($array[0][2] != '-' && $array[0][2] == $array[1][2] && $array[0][2] == $array[2][2]){
            echo 'Ganó ' . $this->activePlayer->getName() . '<br>';
                self::stop();
        }
    }
    public function stop()
    {
        echo 'Game Over <br>';
        $this->board = [];
    }

}

$board = new Board(3, 3);
$player1 = new Player('Pepe', 'X');
$player2 = new Player('Cacho', 'O');
$tateti = new TatetiTwoPlayers($player1, $player2, $board);
$tateti->play(0, 0);
$tateti->play(0, 1);
$tateti->play(1, 0);
$tateti->play(1, 1);
$tateti->play(0, 2);
$tateti->play(1, 2);
$tateti->play(2, 1);
$tateti->play(2, 0);
$tateti->play(2, 2);









