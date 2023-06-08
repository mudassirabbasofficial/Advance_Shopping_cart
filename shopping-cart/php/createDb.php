<?php
    class CreateDb{
        public $servername;
        public $username;
        public $password;
        public $dbname;
        public $tablename;
        public $con;


        //class constructor
        public function __construct(
            $dbname = "Newdb",
            $tablename = "Productdb",
            $servername = "localhost",
            $username = "root",
            $password = ""
        )
        {
            $this->dbname = $dbname;
            $this->tablename = $tablename;
            $this->servername = $servername;
            $this->username = $username;
            $this->password = $password;

            //create connection
            $this->con = mysqli_connect($servername, $username, $password, $dbname);

            if(!$this->con){
                die("Connection failed: " . mysqli_connect_error());
            }

            //create database if it doesn't exist
            $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

            if(mysqli_query($this->con, $sql)){
                //select the database
                // mysqli_select_db($this->con, $dbname); or
                $this->con = mysqli_connect($servername, $username, $password, $dbname);


                //create table if it doesn't exist
                $sql = "CREATE TABLE IF NOT EXISTS $tablename(
                    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    product_name VARCHAR(25) NOT NULL,
                    product_price FLOAT,
                    product_image VARCHAR(100)
                 );";

                 if(!mysqli_query($this->con, $sql)){
                    echo "Error creating table: " . mysqli_error($this->con);
                 }

            }else{
                echo "Error creating database: " . mysqli_error($this->con);
            }

            //close connection
            // mysqli_close($this->con);
        }

        // ger product from the database
        public function getData(){
            $sql = "SELECT * FROM $this->tablename";
            $result = $this->con->query($sql);
            if($result->num_rows > 0 ){
                return $result;
            }

        }
    }
?>