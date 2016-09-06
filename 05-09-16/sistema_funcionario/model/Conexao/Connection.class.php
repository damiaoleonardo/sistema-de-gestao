<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Connection
 *
 * @author leonardo
 */
class Connection {

    // Instância da classe
    private static $instance = null;
    private $conn;

    // Construtor privado: só a própria classe pode invocá-lo
    private function __construct() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $banco = "sistema_de_gestao";

        try {
          $this->conn = mysql_connect($host,$user,$pass);
          mysql_select_db($banco,$this->conn);
	// Definindo o charset como utf8 para evitar problemas com acentuação
	  $charset = mysql_set_charset('utf8');
        } catch (Exception $e) {
            die("Erro na conexão com MySQL! " . $e->getMessage());
        }
    }
    // método estático
    static function getInstance() {
        // Já existe uma instância?
        if (self::$instance == NULL) {
            // Não existe, cria a instância 
            self::$instance = new Connection();
        }
        return self::$instance;    // Já existe, simplesmente retorna
    }
    // Previne o uso de clone
    private function __clone() {
        
    }
}
