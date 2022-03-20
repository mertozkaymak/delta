<?php

    header("Access-Control-Allow-Origin: *");
    require_once(__DIR__ . "/ideasoft/api.config.php");
    
    class Database{

        public $dbh;

        public function connect() {

            try {
                
                $this->dbh = new PDO("mysql:host=" . HOST . "; dbname=" . DBNAME . "; charset=utf8;", USER, PASS);
                
            } catch (PDOException $ex) {

                $ex->getMessage();

            }

        }

        public function disconnect() {

            $this->dbh = NULL;

        }

    }

    $database = new Database();
    $database->connect();

    if(isset($_POST["proggress"]) && $_POST["proggress"] == 0){

        $smtp = $database->dbh->prepare("SELECT * FROM main_category");
        $smtp->execute();
        $result = $smtp->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) > 0){

            $selectbox = '<div class="row d-flex justify-content-center">';
            $selectbox .= '<select class="form-select w-50" id="main_category"><option value="default">Lütfen bir kategori seçiniz.</option>';

            for ($index=0; $index < count($result); $index++) {

                $selectbox .= '<option value="' . $result[$index]["iid"] . '">' . $result[$index]["name"] . '</option>';

            }

            $selectbox .= '</select></div>';
            echo json_encode($selectbox);

        }

    }

    if(isset($_POST["proggress"]) && $_POST["proggress"] == 1){

        $smtp = $database->dbh->prepare("SELECT * FROM alt_category_1 WHERE parent_id = ?");
        $smtp->execute(array($_POST["value"]));
        $result = $smtp->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) > 0){

            $selectbox = '<div class="row d-flex justify-content-center">';
            $selectbox .= '<select class="form-select w-50 mt-3" id="alt_category_1"><option value="default">Lütfen bir kategori seçiniz.</option>';

            for ($index=0; $index < count($result); $index++) {

                $selectbox .= '<option value="' . $result[$index]["iid"] . '">' . $result[$index]["name"] . '</option>';

            }

            $selectbox .= '</select></div>';
            echo json_encode($selectbox);

        }

    }

    if(isset($_POST["proggress"]) && $_POST["proggress"] == 2){

        $smtp = $database->dbh->prepare("SELECT * FROM alt_category_2 WHERE parent_id = ?");
        $smtp->execute(array($_POST["value"]));
        $result = $smtp->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) > 0){

            $selectbox = '<div class="row d-flex justify-content-center">';
            $selectbox .= '<select class="form-select w-50 mt-3" id="alt_category_2"><option value="default">Lütfen bir kategori seçiniz.</option>';

            for ($index=0; $index < count($result); $index++) {

                $selectbox .= '<option value="' . $result[$index]["iid"] . '">' . $result[$index]["name"] . '</option>';

            }

            $selectbox .= '</select></div>';
            echo json_encode($selectbox);

        }

    }

    if(isset($_POST["proggress"]) && $_POST["proggress"] == 3){

        $smtp = $database->dbh->prepare("SELECT * FROM alt_category_2 WHERE iid=?");
        $smtp->execute(array($_POST["value"]));
        $result = $smtp->fetch(PDO::FETCH_ASSOC);
        
        echo '<div class="d-none" id="head-content">' . $result["showcaseContent"] . '</div>';

    }

    $database->disconnect();

?>