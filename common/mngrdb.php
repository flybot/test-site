<?php


class MngrDB{
    # Class for easy acess to db (like python/zope|false)
    # made by me (shevayura)
    private $hostname = "";
    private $username = "";
    private $password = "";
    private $dbName   = "";
    public  $dbConn;

    function  __construct($hostname=null, $username=null, $password=null, $dbname=null) {
        if ($hostname !== null) $this->hostname = $hostname;
        if ($username !== null) $this->username = $username;
        if ($password !== null) $this->password = $password;
        if (  $dbname !== null)   $this->dbName = $dbname;

        $this->dbConn = mysql_connect($this->hostname, $this->username, $this->password)
                or die("Не могу создать соединение c базой данных!");
        mysql_select_db($this->dbName, $this->dbConn) or die(mysql_error());
        mysql_query("SET NAMES 'utf8'", $this->dbConn);
        mysql_query("SET collation_connection = 'UTF-8_general_ci'", $this->dbConn);
        mysql_query("SET collation_server = 'UTF-8_general_ci'", $this->dbConn);
        mysql_query("SET character_set_client = 'UTF-8'", $this->dbConn);
        mysql_query("SET character_set_connection = 'UTF-8'", $this->dbConn);
        mysql_query("SET character_set_results = 'UTF-8'", $this->dbConn);
        mysql_query("SET character_set_server = 'UTF-8'", $this->dbConn);
    }

    public function mysqlGet($query, $db=null, $key=false){
        if (!$db) $db = $this->dbConn;
        $result = mysql_query($query, $db);
        if (!$result) return array();
        for ( $data=array(); $row=mysql_fetch_assoc($result); $key!==false && array_key_exists($key, $row) ? $data[$row[$key]]=$row : $data[]=$row);
        return $data;
    }

    public function mysqlGetOne($query, $db=null){
        if (!$db) $db = $this->dbConn;
        $result = mysql_query($query, $db);
        if (!$result) return array();
        $row = mysql_fetch_assoc($result);
        return $row ? $row : array();
    }

    public function mysqlGetKV($query, $key, $value, $db=null){
        if (!$db) $db = $this->dbConn;
        $result = mysql_query($query, $db);
        if (!$result) return array();
        for ( $data=array(); $row=mysql_fetch_assoc($result); $data[$row[$key]]=$row[$value] );
        return $data;
    }

    public final function mysqlGetCount($table, $where=1, $db=null){
        #not safe!
        if (!$db) $db=$this->dbConn;
        $table = mysql_real_escape_string($table);
        $query = "SELECT COUNT(*) as 'rows' FROM `$table` WHERE $where";
        $result = mysql_query($query);
        @$result = mysql_fetch_assoc($result);
        return (int)$result['rows'];
    }

    public function mysqlListFields($table){
        $res = mysql_list_fields($this->dbName, $table, $this->dbConn);
        for ( $data=array(), $i=0; $i<mysql_num_fields($res); $data[]=strtolower(mysql_field_name($res, $i)), $i++);
        return $data;
    }
    public function mysqlIsHaveField($table, $field){
        return in_array(strtolower($field), $this->mysqlListFields($table));
    }
    public function mysqlInsertArray($table, $array, $skipSpecCh=0, $db=null, $skipEscape=0){
        if (!$db) $db = $this->dbConn;
        if (get_magic_quotes_gpc())
            $array  = array_map( 'stripslashes',        $array );
        if ( !$skipSpecCh ){
            $array  = array_map( 'stripslashes',     $array );
            $array  = array_map( 'htmlspecialchars', $array );
        }
        if ( !$skipEscape ){
            $array  = array_map( 'mysql_real_escape_string', $array );
        }

        $names  = '`'.join("`, `", array_keys($array)).'`';
        $values = "'" . join("', '", array_values($array)) . "'";
        $query = "INSERT INTO $table ($names) VALUES ($values)";
        mysql_query($query, $db);
    }

    public function mysqlUpdateArray( $table, $set, $where, $skipSpecCh=0, $db=null, $skipEscape=0 ){
        if (!$db) $db = $this->dbConn;
        if (get_magic_quotes_gpc())
            $set  = array_map( 'stripslashes',        $set );
        if ( !$skipSpecCh ){
            $set  = array_map( 'stripslashes',     $set );
            $set  = array_map( 'htmlspecialchars', $set );
        }
        if ( !$skipEscape ){
            $set  = array_map( 'mysql_real_escape_string', $set );
        }

        foreach ( $set as $k=>$v ){
            $k = mysql_real_escape_string($k);
            $set[$k] = "`$k`='$v'";
        }

        $set = join(", ", $set);

        $query = "UPDATE `$table` SET $set WHERE $where";
        mysql_query($query, $db);
        #echo "$query<br>\n";
        #echo mysql_error($db)."<br>\n";
    }
}



$mngrDB = new MngrDB($dbhost, $dbuser, $dbpasswd, $dbname);


?>
