<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Collections
 *
 * @author ziki
 */
class Collections extends MY_Model {

    //collections table has 4 column: Datetime, Piece, Player,and Token
    function __construct() {
        //collections table and column token
        parent::__construct('collections', 'token');
    }

    //count pieces that player have
    function countPieces() {
        //SELECT `Player`, Count(Player) FROM `collections` Group By Player
        $query = $this->db->query("SELECT player,count(player) AS 'pieces' FROM collections GROUP BY player");
        return $query->result();
    }

    //count top
    //SELECT `Player`, Count(Player) AS "TOP" FROM `collections` WHERE `Piece` LIKE "%0%" Group By Player
    function countTop() {
        $query = $this->db->query("SELECT player, Count(Player) AS top FROM collections WHERE Piece LIKE '%-0%' Group By player");
        return $query->result();
    }

    //count mid
    //SELECT `Player`, Count(Player) AS "MID" FROM `collections` WHERE `Piece` LIKE "%-1%" Group By Player;
    function countMid() {
        $query = $this->db->query("SELECT player, Count(Player) AS mid FROM collections WHERE Piece LIKE '%-1%' Group By player");
        return $query->result();
    }

    //count bottom
    //SELECT `Player`, Count(Player) AS "bottom" FROM `collections` WHERE `Piece` LIKE "%-2%" Group By Player
    //count top, mid , bottom
    function countDiffPieces() {
        $query = $this->db->query("SELECT players.player, COALESCE(top,0) AS top ,COALESCE(mid,0) AS mid, COALESCE(bottom,0) AS bottom
    FROM players
    LEFT JOIN 
(SELECT player, Count(player) AS top FROM collections WHERE piece LIKE '%-0%' Group By Player) a 
ON players.Player = a.player
LEFT JOIN 
(SELECT player, Count(Player) AS mid FROM collections WHERE piece LIKE '%-1%' Group By Player) b 
ON players.Player = b.player
LEFT JOIN
(SELECT player, Count(Player) AS bottom FROM collections WHERE piece LIKE '%-2%' Group By Player) c 
ON players.Player = c.player");
        return $query->result();
    }

    function countTotal() {
        $query = $this->db->query("SELECT playersbot.playername, playersbot.botnum as totalbots, piecetotal.total as totalpieces
FROM(
SELECT e.pname as playername, 
(
    CASE
	WHEN e.topmid < e.bottom
    THEN e.topmid
    ELSE e.bottom
    END
) AS botnum
FROM (
SELECT d.player AS pname, 
(
    CASE 
	WHEN d.top < d.mid
	THEN d.top
	ELSE d.mid
END) AS topmid, d.bottom as bottom
FROM 
(
SELECT players.Player AS player, COALESCE(top,0) AS top ,COALESCE(mid,0) AS mid, COALESCE(bottom,0) AS bottom
FROM 
players
LEFT JOIN 
(SELECT Player, Count(Player) AS TOP FROM collections WHERE Piece LIKE '%-0%' Group By Player) a 
ON players.Player = a.player
LEFT JOIN
(SELECT Player, Count(Player) AS MID FROM collections WHERE Piece LIKE '%-1%' Group By Player) b 
ON players.Player = b.player
LEFT JOIN
(SELECT Player, Count(Player) AS BOTTOM FROM collections WHERE Piece LIKE '%-2%' Group By Player) c 
ON players.Player = c.player
) d
) e
) playersbot
JOIN (
SELECT Player, Count(Player) as total FROM collections Group By Player
    ) piecetotal
    ON playersbot.playername = piecetotal.player");
        return $query->result();
    }

    function pieceselected() {
        $query = $this->db->query("Select a.player AS player, b.peanuts AS peanuts,(a.total+b.peanuts) AS total FROM (SELECT Player, Count(Player) as total FROM collections Group By Player) a
JOIN 
(SELECT player, peanuts FROM players) b
ON a.player = b.player");
        return $query->result();
    }

    function topselect($playername) {
        $query = $this->db->query("Select player,piece, token, datetime from collections WHERE player ='$playername'&& piece LIKE '%-0%'");
        return $query->result();
    }

    function midselect($playername) {
        $query = $this->db->query("Select player,piece, token, datetime from collections WHERE player ='$playername'&& piece LIKE '%-1%'");
        return $query->result();
    }

    function bottomselect($playername) {
        $query = $this->db->query("Select player,piece, token, datetime from collections WHERE player ='$playername'&& piece LIKE '%-2%'");
        return $query->result();
    }

    function awarepiece() {
        $query = $this->db->query("SELECT piece FROM collections GROUP BY Piece");
        return $query->result();
    }

    function insertCertificate($token, $piece, $player, $datetime) {
        $data = array(
            'token' => $token,
            'piece' => $piece,
            'player' => $player,
            'datetime' => $datetime
        );

        $this->db->insert('collections', $data);
    }

    function truncate() {

        $this->db->truncate('collections');
    }

    function tokenPiece($token){
                if (!empty($token)) {
            $this->db->select('piece');
            $this->db->from('collections');
            $this->db->where('token', (string) $token);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                return $query->row()->piece;
            } else {
                return false;
            }
        }
    }
}
