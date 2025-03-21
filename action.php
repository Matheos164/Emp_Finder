<!-- Notes

* Create the Next and Previous BTNS 
      -Need to be configured to eather work with the POST=action.php?act=allEMP OR Re-work the system to not use that post method



-->

<?php
session_start();
require('connect.php');
$employeeDetails = array();
// get values from input fields
$Act = filter_input( INPUT_GET, 'act', FILTER_SANITIZE_SPECIAL_CHARS);
$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$location = filter_input( INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS);
$floor = filter_input( INPUT_POST, 'floor', FILTER_SANITIZE_SPECIAL_CHARS);
$cubical = filter_input( INPUT_POST, 'cubical');

$SESHname = $_SESSION['name'];
$SESHlocation = $_SESSION['location'];
$SESHfloor = $_SESSION['floor'];
$SESHcubical = $_SESSION['cubical'];

$display = '';


    // cycle functions 
$o = filter_input(INPUT_GET, "start", FILTER_VALIDATE_INT);
if($o !== null  && $o >= 0){
      $offset = $o;
}else{
      $offset = 0;
}

$l = filter_input(INPUT_GET, "view", FILTER_VALIDATE_INT);
if($l !== null  && $l >= 1 && $l <= 7){
      $limit = $l;
}else{
      $limit = 7;
}

if($action == 'remEMP'){
      $remQuery = "DELETE FROM emp WHERE Name = '$name' AND Location = '$location' LIMIT 1";
      $stms = $dbh->prepare($remQuery);
      $result = $stms->execute();

}elseif($Act == 'edit'){
      $display = "
      <h1 class='text-center pt-3'>Edit Employee</h1>
      <h3 class='text-center pt-3'>Try Editing Sandra B!</h3>
      <form method='post' action='action.php?act=editEMP'>

            <div class='info text-center'>
                  <label for='name' class='lead'>Full Name</label>
                  <input type='text' name='name' maxlength='40'  value='$SESHname'>
            </div>

            <div class='info text-center pb-2' >
                  <label for='location' class='lead'>location:</label>

                  <input type='radio' value='john' id='john' name='location' onclick='showPictures(); GenerateDropDown();'>
                  <label for='location' >John</label>

                  <input type='radio' value='nebo' id='nebo' name='location' onclick='showPictures(); GenerateDropDown();'>
                  <label for='location'>Nebo</label>

                  <input type='radio' value='vansickle' id='vansickle' name='location' onclick='showPictures(); GenerateDropDown();'>
                  <label for='location'>Vansickle</label>
            </div>

            <div id='floorCont' class='info text-center hide'>
                  <label for='floor' class='lead'>Floor</label>
                  <select name='floor' id='floor' onchange='showPictures();'>        
                  </select>
            </div>

            <div class='info text-center'>
                  <label for='cubical' class='lead'>Cubical ID</label>
                  <input type='text' name='cubical' maxlength='6' placeholder='J-123'>
            </div>
            
            <div class='info text-center' >
                  <button class='action' type='submit'>Edit Employee</button>
            </div>
      </form>


      ";
      

}elseif($Act == 'add'){
      if(empty(trim($name) || $location || $floor || trim($cubical)) || empty(trim($name) && $location && $floor && trim($cubical))){
            $display = '
                        <h1 class="text-center pt-3">Field Is Missing!</h1>
                        <div class="action_btn">
                              <a href="edit.php"><button type="button" class="action">Go Back</button></a>
                        </div>';
      }else{
            // get values from input fields
            $addQuery = "INSERT INTO emp (Name, Location, Floor, Cubical) 
                  VALUES ('$name', '$location', '$floor', '$cubical')
                  ";
            $stms = $dbh->prepare($addQuery);
            $result = $stms->execute();

            $display = '
                              <h1 class="text-center pt-3">Action completed</h1>
                              <h2 class="text-center pt-3">Plese Do Not Refresh Page</h2>
                              <div class="action_btn">
                                    <a href="edit.php"><button type="button" class="action">Go Back</button></a>
                              </div>';
      }

}elseif($Act == 'editEMP'){
      if(empty(trim($name) || $location || $floor || trim($cubical)) || empty(trim($name) && $location && $floor && trim($cubical))){
            $display = '
                        <h1 class="text-center pt-3">Field Is Missing!</h1>
                        <div class="action_btn">
                              <a href="edit.php"><button type="button" class="action">Go Back</button></a>
                        </div>';
      }else{
            // get values from input fields
            $addQuery = "UPDATE emp SET Name='$name',Location='$location',Floor='$floor',Cubical='$cubical' WHERE Name='$SESHname'AND Location='$SESHlocation' AND Floor='$SESHfloor'AND Cubical='$SESHcubical' LIMIT 1";
            $stms = $dbh->prepare($addQuery);
            $result = $stms->execute();

            $display = '
                              <h1 class="text-center pt-3">Action completed</h1>
                              <h2 class="text-center pt-3">Plese Do Not Refresh Page</h2>
                              <div class="action_btn">
                                    <a href="edit.php"><button type="button" class="action">Go Back</button></a>
                              </div>';
      }

}elseif($Act == 'allEMP'){

      

      $query = "SELECT * FROM emp LIMIT $limit OFFSET $offset;";
            $stms = $dbh->prepare($query);
            $result = $stms->execute();

            while($row = $stms->fetch()){  
                  
                  $res =  "
                        <tr style='text-align:center' ><td>{$row['Name']}</td>
                              <td>{$row['Location']}</td>
                              <td>{$row['Floor']}</td>
                              <td>{$row['Cubical']}</td>
                              <td><div class='container-fluid row text-center p-2'>
                              <button class='btn btn-danger' onclick='remove(\"{$row['Name']}\", \"{$row['Location']}\", \"{$row['Floor']}\", \"{$row['Cubical']}\");'>Remove</button>
                              </div></td>
                        </tr>
                  ";     
                  array_push($employeeDetails, $res);    

            }

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>

     <!--
        Bootstrap links
    -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!--
      Java script and CSS link
    -->
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      


</head>
<body>
<!--------------Header------------------>
    <Header>
      <nav class="navbar navbar-expand-lg bg-body-white mt-1">
            <div class="px-3 container-fluid" style="width: 340px;">
                  <a href="main.php"><img id="logo" src="pics/logo.png" alt="Logo" width="366" height="125" ></a>
            </div>

            <div class="mx-auto">
                  <?php
                  
                        if(!isset($_SESSION['user']) && !isset($_SESSION['id'])){
                              echo'
                              <form method="post" action="login.php" class="login-form">
                                    <label class="fs-4">Login</label>
                                    <br>
                                    <input type="text" class="form-control mt-1" name="username" placeholder="Username">
                                    <input type="password" class="form-control mt-1" name="password" placeholder="Password">
                                    <button class = "btn action mx-1 my-1 container-lg" type="submit" name="login">Login</button>
                              </form>
                              ';
                        }elseif (isset($_SESSION['user']) && isset($_SESSION['id'])){

                              echo '
                              <div class="btn btn-sm btn-block">
                              <label class="fs-4">Hello Admin!</label>
                              <br>
                              <a href="action.php?act=allEMP"hidden ><button type="button" class="fbtn" id="edit" name="edit" >Employee List</button></a>
                              <a href="edit.php"><button type="button" class="fbtn" id="edit" name="edit" >Edit</button></a>
                              <a href="logout.php"> <button type="button" href="logout.php" class="fbtn" id="logout" name="logout" >Logout</button></a>
                        </div>
                              ';
                        }

                        if(isset($_GET['error'])){
                              echo '<p class="error">',$_GET['error'],'</p>';

                        }
                  
                  ?> 
                  
            </div>
            
      </nav>
    </Header>
<!--------------Action------------------>
<main class="edits container-fluid">

<!--------------Add------------------>
      <?php
            echo '<div id="panel">
                  <div class="edit_cont my-3 container-fluid pb-3">';
            
            if($Act == 'allEMP'){
                  
                  echo "<h1 class='text-center pt-3'>All Employee</h1>
                  <table class='table table-hover'>
                  <thead>
                        <tr class='bg-gradient text-center' style='background-color: #52b65b;'>
                              <th>Name</th>
                              <th>Location</th>
                              <th>Floor</th>
                              <th>Cubicle #</th>
                              <th>Action</th>
                        </tr>
                  </thead>
                  <tbody>";
                  foreach($employeeDetails as $data){
                        echo $data;
                  }
                  echo" 
                  </tbody>
                  </table>
                  ";
                  if ($offset == 0){
                        $next = '<input type="submit" value="Next" class="btn btn-secondary">';
                        $previous = '<input type="submit" value="Previous" class="btn btn-secondary disabled">';
                  }elseif($offset > $limit){
                        $next = '<input type="submit" value="Next" class="btn btn-secondary disabled">';
                        $previous = '<input type="submit" value="Previous" class="btn btn-secondary">';
                  }elseif($offset <= $limit){
                        $next = '<input type="submit" value="Next" class="btn btn-secondary">';
                        $previous = '<input type="submit" value="Previous" class="btn btn-secondary">';
                  }elseif($offset == $limit){
                        $next = '<input type="submit" value="Next" class="btn btn-secondary" disabled>';
                        $previous = '<input type="submit" value="Previous" class="btn btn-secondary" disabled>';
                  }
                  echo "<div class='cycleBtn'> 
                  <form class='row p-1' method='post' >
                      <input type='hidden' name='view' value='<?=$limit?>'>
                      <input type='hidden' name='start' value='<?=$offset+$limit ?>'>
                      $next
                  </form>
              
                  <form class='row p-1' >
                      <input type='hidden' name='view' value='<?=$limit?>'>
                      <input type='hidden' name='start' value='<?=$offset-$limit ?>'>
                      $previous
                  </form>
              </div>
              ";

            }else{
                  echo $display;
            }
            
            echo '</div>
                  </div>';


      ?>

      <div id="imageContainer" class="edit_cont my-3 container-fluid pb-3" style="display:none;"></div>
      

                  
</main>

<!---------------Footer----------------->

      <footer>
            <div id="copyright">
                  <span>Created by Matheos Amanuel</span>
                  <br>
                  <span>From Mohawk College</span>
            </div>
      </footer>
</body>
</html>