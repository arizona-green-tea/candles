<?php

class OrdersDb {
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename;
    public $con;

    public function __construct($dbname = "NewDb", $tablename = "OrderDb", $servername = "localhost", $username = "root", $password ="")
    {
        $this->dbname = $dbname;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->password = $password;

        // create connection
        $this->con = mysqli_connect($servername, $username, $password);

        // check connection
        if (!$this->con) {
            die("Connection failed:" . mysqli_connect_error());
        }

        // query
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

        // execute query
        if (mysqli_query($this->con, $sql)) {
            $this->con = mysqli_connect($servername, $username, $password, $dbname);
            // sql to create new table
            $sql = "CREATE TABLE IF NOT EXISTS $tablename
                    (id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    product_name VARCHAR (25) NOT NULL,
                    product_price FLOAT,
                    product_image VARCHAR (100),
                    user_order_id BIGINT,
                    email VARCHAR(50),
                    amount INT(25)
            );";

            if (!mysqli_query($this->con, $sql)) {
                echo "Error creating table :" . mysqli_error($this->con);
            }
            
        } else {
            return false;
        }

    }

    // get product from database
    public function getData() {
        $sql = "SELECT * FROM $this->tablename";
        $result = mysqli_query($this->con, $sql);

        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }

    // insert new account data into database
    public function insert($sql) {
        if (mysqli_query($this->con, $sql)) {
            echo "<script>alert('Checkout success!')</script>";
            echo "<script>window.location = 'cart.php'</script>";
        } else {
            echo "<script>alert('Checkout error!')</script>";
            echo "<script>window.location = 'cart.php'</script>";        
        }
    }

    public function random_number($length) {
        $text = "";
        if($length < 5)
        {
            $length = 5;
        }

        $len = rand(4,$length);

        for ($i=0; $i < $len; $i++) { 
            $text .= rand(0,9);
        }

        return $text;
    }

    // retrieve account info from database
    public function retrieve($sql) {
        $result = mysqli_query($this->con, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
}