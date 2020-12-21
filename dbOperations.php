<?php
    require_once('./config/db1.php');

    function fetchRecordAll($entity,$start=0,$end=10){
        // fetch records for entity(category, article, comment) where status is true
        // start and end will control the behaviour for pagination  
        $sql = "select * from $entity where status = 'A' limit $start, $end";
        global $con;
        $res = mysqli_query($con,$sql);
        $data=array();
        if(mysqli_num_rows($res)>0)
        {
            while($record = mysqli_fetch_assoc($res))
            {
                $data[]=$record;
            }
            return $data;
        }
        else
        {
            return false;
        }
       
    }
       

    function fetchRecordSpecific($entity,$primary){
        // fetch single record for entity(category, article, comment)
        $sql ="";
        $sql = "select * from $entity where id=$primary";
        global $con;
        $res = mysqli_query($con,$sql);
        $data=array();
        if(mysqli_num_rows($res)>0)
        {
            while($record = mysqli_fetch_assoc($res))
            {
                $data=$record;
            }
            return $data;    
        }
        else
        {
            return false;
        }
    
    }

    function insertRecord($entity,$data){
        // insert single record for entity(category, article, comment) with data passed
        //echo 'Insert Called';
        $sql = "";
        global $con;
        if($entity == 'user'){
            $sql = "INSERT INTO user(`name`, `email`, `pwd`, `status`) VALUES ('$data[user]', '$data[email]', '$data[pwd]', 'A')";
            $res = mysqli_query($con, $sql);
            if(mysqli_num_rows($res)>0){
                echo "New record inserted";
            }else{
                echo "Record not inserted";
            }
            
        }
        else if($entity == 'article'){
            $sql = "INSERT INTO article(`author`, `category`, `title`, `content`, `created`, `updated`, `status`) VALUES 
            ('$data[author]', '$data[category]', '$data[title]', '$data[content]', '$data[created]', '$data[updated]', 'A')";
            $res = mysqli_query($con, $sql);
            
        }
        else if($entity == 'category'){
            $sql = "INSERT INTO category(`name`, `description`, `status`, `created`, `updated`) VALUES 
            ('$data[name]', '$data[description]', 'A', '$data[created]', '$data[updated]')";
            $res = mysqli_query($con, $sql);
            if(mysqli_num_rows($res)>0){
                echo "New record inserted";
            }else{
                echo "Record not inserted";
            }
            
        }
        else if($entity == 'comment'){
            $sql = "INSERT INTO comment(`persion`, `content`, `created`, `article`, `status`) VALUES 
            ('$data[person]', '$data[content]',$data[created]', '$data[article]', 'A')";
            $res = mysqli_query($con, $sql);
            
        }

       
    }

    function updateRecord($entity,$primary,$data){
        // update single record for entity(category, article, comment) using its primary key with data passed
        $sql = "";
        global $con;
        if($entity == 'user'){
             $sql = "UPDATE `user` SET `name` = '$data[name]' ,`email` = '$data[email]',`pwd` = '$data[pwd]' ,`status` = '$data[status]'  where `id` = $primary ";
            $res = mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                echo "record updated ";
            }else{
                echo "record not updated";
            }

        }
        else if($entity == 'category'){
            $sql ="";
             $sql = "UPDATE `category` SET `name`='$data[name]',`description`='$data[desc]',`status`='$data[status]' WHERE `id` = $primary";
            $res = mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                echo "record updateded";
            }else{
                echo "Record not updated";
            }

        }
        else if($entity == 'article'){
             $sql = "UPDATE `article` SET `author`= '$data[author]' ,`category` = '$data[category]',`title` = '$data[title]',`content` = '$data[content]', where `id` = $primary ";
            $res = mysqli_query($con,$sql);

        }
        else if($entity == 'comment'){
             $sql = "UPDATE `comment` SET `person`= '$data[person]',`content`= '$data[content]',,`article`= '$data[article]',`status` = '$data[status]'  where `id` = $primary ";
            $res = mysqli_query($con,$sql);

        }
    
       
    }

    function deleteRecord($entity,$primary){
        // delete single record for entity(category, article, comment) using its primary key
        global $con;
        $sql="delete from $entity where id=$primary";
        $res=mysqli_query($con,$sql);
        if(mysqli_affected_rows($GLOBALS['con'])>0)
        {
            return ture;
        }
        else
        {
            return false;
        }
    }

    function authenticate($username, $pwd){
        // if successful, redirect to dashboard
        // else stay on login page
        require_once('config/db1.php');
        global $con;
        $sql = "select * from user where name ='$username' and status ='A' and pwd ='$pwd'";
        $res = mysqli_query($con, $sql);
        return $res;
       
    }
?>