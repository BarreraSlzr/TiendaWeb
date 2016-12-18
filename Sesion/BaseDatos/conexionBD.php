<?php
    $conexionBD = false;

    function conectarBaseDatos()
    {
        global $conexionBD;
        if( $conexionBD )
            return $conexionBD;
        $conexionBD = mysql_connect("localhost", "admin", "m45fLZfsMQNbJcBv");
        mysql_select_db('internetFriends-Store', $conexionBD) or die('Could not select database.');
        return $conexionBD;
    }
?>
