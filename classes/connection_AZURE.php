<?php
/**
 * Encapsulates a connection to the database 
 * 
 * @author Arturo Mora-Rioja
 * @date   September 2019
 */
    class DB {

        /**
         * Opens a connection to the database
         * 
         * @returns a connection object
         */
        public function connect() {
            $cServer = 'kea.database.windows.net';
            $cPort = '1433';
            $cDB = 'movies';
            $cUser = 'kea';
            $cPwd = 'Technology1';

            $cDSN = 'sqlsrv:server = tcp:' . $cServer . ',' . $cPort . '; Database = ' . $cDB;

            try {
                $cnDB = @new PDO($cDSN, $cUser, $cPwd); 
            } catch (\PDOException $oException) {
                echo 'Connection unsuccessful';
                die('Connection unsuccessful: ' . $oException->getMessage());
                exit();
            }
            
            return($cnDB);   
        }

        /**
         * Closes a connection to the database
         * 
         * @param the connection object to disconnect
         */
        public function disconnect($pcnDB) {
            $pcnDB = null;
        }
    }
?>