<?php

/**
 * Get a database backup based on the initial selection query
 *
 */
class MySQLDump {

    var $tables = array();
    var $connected = false;
    var $output;
    var $droptableifexists = false;
    var $mysql_error;

    function connect($host, $user, $pass, $db) {
        $return = true;
        $conn = @mysql_connect($host, $user, $pass);
        mysql_set_charset('utf8', $conn);
        if (!$conn) {
            $this->mysql_error = mysql_error();
            $return = false;
        }
        $seldb = @mysql_select_db($db);
        if (!$conn) {
            $this->mysql_error = mysql_error();
            $return = false;
        }
        $this->connected = $return;
        return $return;
    }

    function list_tables() {
        $return = true;
        if (!$this->connected) {
            $return = false;
        }
        $this->tables = array();
        $sql = mysql_query("SHOW TABLES");

        while ($row = mysql_fetch_array($sql)) {
            array_push($this->tables, $row[0]);
        }
        return $return;
    }

    function list_values($tablename) {
        $sql = mysql_query("SELECT * FROM $tablename");
        $this->output .= "\n\n-- Dumping data for table: $tablename\n\n";
        while ($row = mysql_fetch_array($sql)) {
            $broj_polja = count($row) / 2;
            $this->output .= "INSERT INTO `$tablename` VALUES(";
            $buffer = '';
            for ($i = 0; $i < $broj_polja; $i++) {
                $vrednost = $row[$i];
                // echo "<pre>$vrednost</pre>";
                if (!is_integer($vrednost)) {
                    $vrednost = "'" . mysql_real_escape_string($vrednost) . "'";
                }
                $buffer .= $vrednost . ', ';
            }
            $buf = substr($buffer, 0, count($buffer) - 3);
            $this->output .= $buf . ");\n";
        }
    }

    function dump_table($tablename) {
        $this->output = "";
        $this->get_table_structure($tablename);
        $this->list_values($tablename);
    }

    function get_table_structure($tablename) {
        $this->output .= "\n\n-- Dumping structure for table: `{$tablename}`\n\n";
        if ($this->droptableifexists) {
            $this->output .= "DROP TABLE IF EXISTS `{$tablename}`;\n";
        }
        $sql = mysql_query("SHOW CREATE TABLE {$tablename}");
        if ($sql) {
            $row = mysql_fetch_array($sql);
            $this->output .= $row[1];
            $this->output .= ";\n\n";
        } else {
            $this->output .= "-- Error in getting create of `{$tablename}`";
        }
    }

}