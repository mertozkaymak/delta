<?php

    require_once(__DIR__ . "/api.connection.php");
    require_once(__DIR__ . "/api.config.php");

    class Categories extends Tokenizer{

        protected $categories = array();

        public function __construct() {

            $tokenizer = new Tokenizer();
            $status = $tokenizer->tokenController();

            if($status == 1){

                $page = 1;
                $total_pages = 0;
                $stop = 0;

                while ($stop == 0) {

                    $url = URL . "/api/categories?limit=100&sort=id&page=" . $page;
                    $variables = array("Authorization: Bearer " . $tokenizer->acc, "Content-Type: application/json; charset=utf-8");

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HEADER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $variables);

                    $res = curl_exec($ch);
                    curl_close($ch);
                    
                    $response = explode("[{", $res, 2);
                    $header = $response[0];
                    $body = $response[1];

                    if($total_pages == 0){

                        $total_pages = floor(intval(trim(explode(":", explode("\n", $header)[7])[1])) / 100) + 1;
                        
                    }

                    if($page == $total_pages){

                        $stop = 1;

                    }
                    else{

                        $page++;
                        sleep(2);

                    }

                    $body = "[{" . $body;
                    $body = json_decode($body);
                    array_push($this->categories, $body);

                }

                $this->asyncCategories();
                
            }

        }

        public function asyncCategories() {

            $database = new Database();
            $database->connect();

            for ($page=0; $page < count($this->categories); $page++) { 

                for ($category=0; $category < count($this->categories[$page]); $category++) {

                    if(!is_numeric(strpos($this->categories[$page][$category]->showcaseContent, "Ölçü"))){

                        continue;

                    }

                    if($this->categories[$page][$category]->id == "2215" || $this->categories[$page][$category]->parent->id == "2214" || $this->categories[$page][$category]->id == "2216"){

                        continue;

                    }

                    echo "<pre>";
                    print_r($this->categories[$page][$category]);
                    echo "<pre>";
                    
                    if(!is_null($this->categories[$page][$category]->parent->parent)){

                        $smtp = $database->dbh->prepare("SELECT * FROM main_category WHERE iid = ?");
                        $smtp->execute(array(
                            $this->categories[$page][$category]->parent->parent->id
                        ));
                        $result = $smtp->fetchAll();

                        if(count($result) > 0){

                            $smtp = $database->dbh->prepare("UPDATE main_category SET name=?, status=? WHERE iid=?");
                            $smtp->execute(array(
                                $this->categories[$page][$category]->parent->parent->name,
                                $this->categories[$page][$category]->parent->parent->status,
                                $this->categories[$page][$category]->parent->parent->id
                            ));

                        }
                        else{

                            $smtp = $database->dbh->prepare("INSERT INTO main_category (iid, name, status) VALUES (?, ?, ?)");
                            $smtp->execute(array(
                                $this->categories[$page][$category]->parent->parent->id,
                                $this->categories[$page][$category]->parent->parent->name,
                                $this->categories[$page][$category]->parent->parent->status
                            ));

                        }

                    }

                    if(!is_null($this->categories[$page][$category]->parent)){

                        $smtp = $database->dbh->prepare("SELECT * FROM alt_category_1 WHERE iid = ?");
                        $smtp->execute(array(
                            $this->categories[$page][$category]->parent->id
                        ));
                        $result = $smtp->fetchAll();

                        if(count($result) > 0){

                            $smtp = $database->dbh->prepare("UPDATE alt_category_1 SET name=?, status=?, parent_id=? WHERE iid=?");
                            $smtp->execute(array(
                                $this->categories[$page][$category]->parent->name,
                                $this->categories[$page][$category]->parent->status,
                                $this->categories[$page][$category]->parent->parent->id,
                                $this->categories[$page][$category]->parent->id
                            ));

                        }
                        else{

                            $smtp = $database->dbh->prepare("INSERT INTO alt_category_1 (iid, name, status, parent_id) VALUES (?, ?, ?, ?)");
                            $smtp->execute(array(
                                $this->categories[$page][$category]->parent->id,
                                $this->categories[$page][$category]->parent->name,
                                $this->categories[$page][$category]->parent->status,
                                $this->categories[$page][$category]->parent->parent->id
                            ));

                        }

                    }

                    $smtp = $database->dbh->prepare("SELECT * FROM alt_category_2 WHERE iid = ?");
                    $smtp->execute(array(
                        $this->categories[$page][$category]->id
                    ));
                    $result = $smtp->fetchAll();

                    if(count($result) > 0){

                        $smtp = $database->dbh->prepare("UPDATE alt_category_2 SET name=?, status=?, parent_id=?, showcaseContent=? WHERE iid=?");
                        $smtp->execute(array(
                            $this->categories[$page][$category]->name,
                            $this->categories[$page][$category]->status,
                            $this->categories[$page][$category]->parent->id,
                            $this->categories[$page][$category]->showcaseContent,
                            $this->categories[$page][$category]->id
                        ));

                    }
                    else{

                        $smtp = $database->dbh->prepare("INSERT INTO alt_category_2 (iid, name, status, parent_id, showcaseContent) VALUES (?, ?, ?, ?, ?)");
                        $smtp->execute(array(
                            $this->categories[$page][$category]->id,
                            $this->categories[$page][$category]->name,
                            $this->categories[$page][$category]->status,
                            $this->categories[$page][$category]->parent->id,
                            $this->categories[$page][$category]->showcaseContent,
                        ));

                    }
                }

            }

        }

    }

    new Categories();

?>