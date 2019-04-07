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
            $this->areWinner();
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
        $full = $this->board->isFull();
        if($full){
            echo 'Empate';
            //self::stop();
        }
        //var_dump($this->board->getBoard());die;

        $array = $this->board->getBoard();
        foreach($array as $v){
            if($v[0] != '-' && $v[0] == $v[1] && $v[0] == $v[2]){
                echo 'Ganó ' . $this->activePlayer->getName() . '<br>';
                //self::stop();
                $this->stop();
            }
        }
        if($array[0][0] != '-' && $array[0][0] == $array[1][0] && $array[0][0] == $array[2][0]){
            echo 'Ganó ' . $this->activePlayer->getName() . '<br>';
                //self::stop();
                $this->stop();
        }
        if($array[0][1] != '-' && $array[0][1] == $array[1][1] && $array[0][1] == $array[2][1]){
            echo 'Ganó ' . $this->activePlayer->getName() . '<br>';
                //self::stop();
                $this->stop();
        }
        if($array[0][2] != '-' && $array[0][2] == $array[1][2] && $array[0][2] == $array[2][2]){
            echo 'Ganó ' . $this->activePlayer->getName() . '<br>';
                //self::stop();
                $this->stop();
        }
    }
    public function stop()
    {
        echo 'Game Over <br>';
        $this->board = [];
    }

}

class BatlleShipTwoPlayers
{
    private $boards = [];
    private $players = [];
    private $turn = false;

    public function __construct(Player $player1, Player $player2,Board $board1, Board $board2)
    {
        $this->players[0] = $player1;
        $this->players[1] = $player2;
        $this->boards[0] = $board1;
        $this->boards[1] = $board2;
        /* $this->turn[0] = $player1;
        $this->turn[0] = $player2; */


    }
    public function play($positionX, $positionY)
    {   
        
        if(!$this->turn){
            $position = $this->boards[1]->giveMePosition($positionX, $positionY);
            $mark = $this->players[1]->getMark();
            if($position == $mark){
                $this->boards[1]->draw($positionX, $positionY, '-');
                echo 'Tocado <br>';
            }else{
                echo 'Agua <br>';
            }
            $this->turn = true;
            
        }elseif($this->turn){
            $position = $this->boards[0]->giveMePosition($positionX, $positionY);
            $mark = $this->players[0]->getMark();
            if($position == $mark){
                $this->boards[0]->draw($positionX, $positionY, '-');
                echo 'Tocado <br>';
            }else{
                echo 'Agua <br>';
            }
            $this->turn = false;
        }
        

    }
    public function areWinner()
    {

    }
    public function shipPlayer1($positionX, $positionY)
    {
        if($this->boards[0]->giveMePosition($positionX, $positionY) == '-'){
            $this->boards[0]->draw($positionX, $positionY, $this->players[0]->getMark());
        }else{
            echo 'La posición no está disponible <br>';
        }
    }
    public function shipPlayer2($positionX, $positionY)
    {
        if($this->boards[1]->giveMePosition($positionX, $positionY) == '-'){
            $this->boards[1]->draw($positionX, $positionY, $this->players[1]->getMark());
        }else{
            echo 'La posición no está disponible <br>';
        }
        
    }

}

$board = new Board(3, 3);
$player1 = new Player('Pepe', 'X');
$player2 = new Player('Cacho', 'O');
$tateti = new TatetiTwoPlayers($player1, $player2, $board);

// Chequea empate

/* $tateti->play(0, 0);
$tateti->play(0, 1);
$tateti->play(1, 0);
$tateti->play(1, 1);
$tateti->play(0, 2);
$tateti->play(2, 0);
$tateti->play(2, 1);
$tateti->play(1, 2);
$tateti->play(2, 2);
 */

//Gana jugador1

/* $tateti->play(0, 0);
$tateti->play(1, 0);
$tateti->play(0, 1);
$tateti->play(2, 0); 
$tateti->play(0, 2);
$tateti->play(1, 1); */

$board1 = new Board(10, 10);
$board2 = new Board(10, 10);
$batlle = new BatlleShipTwoPlayers($player1, $player2, $board1, $board2);
//$board2->show();die;
$batlle->shipPlayer1(0, 0);
$batlle->shipPlayer1(0, 1);
$batlle->shipPlayer1(0, 2);
$batlle->shipPlayer1(0, 3);
$batlle->shipPlayer2(1, 0);
$batlle->shipPlayer2(1, 1);
$batlle->shipPlayer2(1, 2);
$batlle->shipPlayer2(1, 3);
$board1->show();
$board2->show();

$batlle->play(1, 1);

$board1->show();
$board2->show();

$batlle->play(0, 3);

$board1->show();
$board2->show();


//var_dump($batlle);






