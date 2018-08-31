<?php 
    header('Access-Control-Allow-Origin: *');
    $db_host         = 'localhost';
    $db_port         = "";
    $db_user         = 'root';
    $db_password     = '';
    $db_name         = 'leaderboarddb';
    $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password); 
    
    

    if($_GET["task"]){
        switch ($_GET["task"]) {
            case 'getTopList':
                $type = isset($_GET["type"])?$_GET["type"]:"all";

            
                if($type == "all" OR $type == "easy" ){
                    $query = "SELECT * FROM main_leader_board where score_type = 'easy' order by score DESC limit 10";
                    $sth = $dbh->prepare($query);
                    $sth->execute();
                    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $result['easy'] = $res?$res:[];
                }

                if($type == "all" OR $type == "medium" ){
                    $query = "SELECT * FROM main_leader_board where score_type = 'medium' order by score DESC limit 10";
                    $sth = $dbh->prepare($query);
                    $sth->execute();
                    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $result['medium'] = $res?$res:[];
                }

                if($type == "all" OR $type == "hard" ){
                    $query = "SELECT * FROM main_leader_board where score_type = 'hard' order by score DESC limit 10";
                    $sth = $dbh->prepare($query);
                    $sth->execute();
                    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $result['hard'] = $res?$res:[];
                }

                if($type == "all" OR $type == "top" ){
                    $query = "SELECT * FROM normalize_score order by score DESC limit 10";
                    $sth = $dbh->prepare($query);
                    $sth->execute();
                    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $result['top'] = $res?$res:[];
                }

                if(!empty($errors)){
                    $result["success_flag"] = false;
                    $result["error_messages"] = $errors;
                }else{
                    $result["success_flag"] = true;
                    $result["success_message"] = "Success";
                }
                echo json_encode($result);
                die();
            break;
            case 'saveScore':
                
                $userid = $_GET["userid"];
                $level = $_GET["level"];
                $name = $_GET["name"];
                $score = $_GET["score"];
                $type = null;
                if(!isset($userid) OR !isset($name) OR !isset($score)){
                    $errors[] = "Failed to submit score. Wrong Parameter.";
                }
                if(!isset($level)){
                    $errors[] = "Failed to submit score. Wrong Parameter.";
                }else{

                    $os = array("easy", "medium", "hard");

                    if (in_array($level, $os)) {
                        $type = $level;
                    }
                    if($type == null){
                        $errors[] = "Failed to submit score. Wrong Parameter.";
                    }
                }

                if(empty($errors)){
                    $query = "SELECT * FROM main_leader_board WHERE score_type = ? AND userId = ?";
                    $sth = $dbh->prepare($query);
                    $sth->execute(array($level,$userid));
                    $result = $sth->fetch(PDO::FETCH_ASSOC);

                    if(!$result){
                        $sth = $dbh->prepare("INSERT INTO main_leader_board (userId, name, score_type, datetime, score) VALUES (?,?,?,now(),?)");
                        $sth->execute(array($userid,$name,$type,$score));
                    }else{
                       $name = $result['name'];
                       $query = "UPDATE main_leader_board SET score = ? WHERE score_type = ? AND userId = ?";
                       $sth = $dbh->prepare($query);
                       $res = $sth->execute(array($score,$level,$userid));
                       $resultArr['result'] = $res;
                    }

                    //update normalization

                    $query = "SELECT sum(score) as totalscore FROM main_leader_board WHERE userId = ?";
                    $sth = $dbh->prepare($query);
                    $sth->execute(array($userid));
                    $result = $sth->fetch(PDO::FETCH_ASSOC);

                    if($result){
                        $score = $result['totalscore'];

                        $query = "SELECT * FROM normalize_score WHERE userId = ?";
                        $sth = $dbh->prepare($query);
                        $sth->execute(array($userid));
                        $result = $sth->fetch(PDO::FETCH_ASSOC);

                        if(!$result){
                            $sth = $dbh->prepare("INSERT INTO normalize_score (userId, name, score) VALUES (?,?,?)");
                            $sth->execute(array($userid,$name,$score));
                        }else{
                           $query = "UPDATE normalize_score SET score = ? WHERE userId = ?";
                           $sth = $dbh->prepare($query);
                           $res = $sth->execute(array($score,$userid));
                        }

                    }
                }


                if(!empty($errors)){
                    $resultArr["success_flag"] = false;
                    $resultArr["error_messages"] = $errors;
                }else{
                    $resultArr["success_flag"] = true;
                    $resultArr["success_message"] = "Success";
                }
                echo json_encode($resultArr);

                die();
            break;
            default:
                break;
        }
    }else if($_POST){
        if($_POST['task']){
            if($_POST['task'] == "saveNewUser"){
                //echo json_encode( array("Data" => $_POST ) ); 
                die("x");
            }
        }
    }else{
        echo "error";
        die();
    }
        echo "error";
        die();
?>