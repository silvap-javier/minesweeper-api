<?php

/*
  Document   : front
  Author     : Silva Pablo
  Web Developer
 */

Class Basic extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function save($table, $id_field,$data = array()) {
        if (!isset($data[$id_field]) || empty($data[$id_field])) {
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        } else {
            $this->db->where($id_field, $data[$id_field]);
            $this->db->update($table, $data);
            return $data[$id_field];
        }
    }

    function get_all($table, $order = false, $ord = 'asc', $limit = false, $l = false) {
        if ($order)
            $this->db->order_by($order, $ord);
        if ($l)
            $this->db->limit($limit, $l);
        elseif ($limit)
            $this->db->limit($limit);
        return $this->db->get($table);
    }

    function get_where($table, $where_array, $order = false, $or = 'asc', $limit = false, $l = false) {
        if ($order)
            $this->db->order_by($order, $or);
        if ($l)
            $this->db->limit($limit, $l);
        elseif ($limit)
            $this->db->limit($limit);
        return $this->db->get_where($table, $where_array);
    }

    function get_card($round, $game) {
        $cards = "SELECT * FROM cards INNER JOIN cards_by_round on cards.cards_id = cards_by_round.cbr_card WHERE cards_by_round.cbr_round = $round";
        $cards = $this->db->query($cards);

        if ($cards->num_rows() == 0) {
            $cards = "SELECT * FROM cards";
            $cards = $this->db->query($cards);
            $array_cards = $cards->result_array();
            $my_card = $array_cards[rand(0, $cards->num_rows() - 1)];
            $this->save('games', 'game_id', array('game_id' => $game, 'game_last_card' => $my_card['cards_id']));
            $this->save('cards_by_round', 'cbr_id', array('cbr_round' => $round, 'cbr_card' => $my_card['cards_id'], 'cbr_status' => 1));
        }
        return $my_card;
    }

    function get_player($round, $game) {
        $players = "SELECT * FROM players INNER JOIN games on players.players_round = games.game_round WHERE games.game_id = $game AND games.game_round = $round";
        $players = $this->db->query($players);

        if ($players->num_rows() == 0) {
            $players = "SELECT * FROM players";
            $players = $this->db->query($players);
            $array_players = $players->result_array();
            $my_player = $array_players[rand(0, $players->num_rows() - 1)];
            $this->save('games', 'game_id', array('game_id' => $game, 'game_last_player' => $my_player['players_id']));
            $this->save('players', 'players_id', array('players_id' => $my_player['players_id'], 'players_round' => $round));
        }
        return $my_player;
    }

    function get_where_with_betweteen($type, $remiseria, $start = false, $end = false) {
        $query = "SELECT * from pedidos WHERE (pedidos_status = '$type') AND (pedidos_remiseria = '$remiseria') AND (createdAt >='$start') AND (createdAt >='$end')";
        return $this->db->query($query);
    }

    function del($table, $id_field, $id) {
        $this->db->delete($table, array($id_field => $id));
    }

}
