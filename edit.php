<?php
      session_start();
      require('connect.php');

      $searchErr = '';
      $employeeDetails = array();
      $_SESSION['name'] = '';
      $_SESSION['location'] = '';
      $_SESSION['floor'] = '';
      $_SESSION['cubical'] = '';

      if(isset($_POST['save'])){      
            if(!empty(trim($_POST['search']))){

                  $name = filter_input( INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
                  $LocAction = filter_input( INPUT_GET, 'act', FILTER_SANITIZE_SPECIAL_CHARS);
                  $query = "SELECT * FROM emp WHERE Name LIKE '%$name%';";
                        $stms = $dbh->prepare($query);
                        $result = $stms->execute();
                        $count = $stms->rowCount();

                  if($LocAction == 'rem'){
                        if($count >= 1){
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
                        }else{

                              $searchErr = "No Employee Found!";

                        }    
                  }elseif($LocAction == 'edit'){
                        if($count >= 1){
                              while($row = $stms->fetch()){  
                                    $_SESSION['name'] = $row['Name'];
                                    $_SESSION['location'] = $row['Location'];
                                    $_SESSION['floor'] = $row['Floor'];
                                    $_SESSION['cubical'] = $row['Cubical'];


                                    $res =  "
                                          <form method='post' action='action.php?act=edit'>
                                          <tr style='text-align:center' ><td>{$row['Name']}</td>
                                          <td>{$row['Location']}</td>
                                          <td>{$row['Floor']}</td>
                                          <td>{$row['Cubical']}</td>
                                          <td><div class='container-fluid row text-center p-2'>
                                          <button class='btn btn-warning' type='submit'>Edit</button>
                                          </div></td>
                                          </tr>
                                          </form>
                                          ";
                                    array_push($employeeDetails, $res);  

                              }
                        }else{

                              $searchErr = "No Employee Found!";
                        } 
                  }
            }else{

                  $searchErr = "Field is empty!";
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
                                          <a href="action.php?act=allEMP" hidden><button type="button" class="fbtn" id="edit" name="edit" >Employee List</button></a>
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
      <div class="edit_cont my-3 container-fluid pb-3">
            <h1 class="text-center pt-3">Action</h1>
            <div class="action_btn">
                  <button type="button" class="action" onclick="divToggle('panel1')" name="add" >Add</button>
                  <button type="button" class="action" onclick="divToggle('panel2')" name="edit-emp" >Edit</button>
                  <button type="button" class="action" onclick="divToggle('panel3')" name="remove" >Remove</button>
            </div>
            <div class="text-center">
                  <span class="error " style="color:red;"> <?php echo $searchErr;?></span>
            </div>
      </div>

<!--------------Add------------------>
      <div id="panel1">
            <div class="edit_cont container-fluid my-2 pb-3">
                  <h1 class="text-center pt-3">Add Employee</h1>
                  <h3 class='text-center pt-3'>Try Adding a person!</h3>
                  <form method="post" action="action.php?act=add">

                        <div class="info text-center">
                              <label for="name" class="lead">Full Name</label>
                              <input type="text" name="name" maxlength="40" placeholder="">
                        </div>

                        <div class="info text-center pb-2" >
                              <label for="location" class="lead">location:</label>

                              <input type="radio" value="john" id="john" name="location" onclick="showPictures(); GenerateDropDown();">
                              <label for="location" >John</label>

                              <input type="radio" value="nebo" id="nebo" name="location" onclick="showPictures(); GenerateDropDown();">
                              <label for="location">Nebo</label>

                              <input type="radio" value="vansickle" id="vansickle" name="location" onclick="showPictures(); GenerateDropDown();">
                              <label for="location">Vansickle</label>
                        </div>

                        <div id="floorCont" class="info text-center hide">
                              <label for="floor" class="lead">Floor</label>
                              <select name="floor" id="floor" onchange="showPictures();">        
                              </select>
                        </div>

                        <div class="info text-center">
                              <label for="cubical" class="lead">Cubical ID</label>
                              <input type="text" name="cubical" maxlength="6" placeholder="J-123">
                        </div>
                        
                        <div class="info text-center" >
                              <button class = "action" type="submit">Add Employee</button>
                        </div>
                  </form>
            </div>
            <div id="imageContainer" class="edit_cont my-3 container-fluid pb-3" style="display:none;"></div>
      </div>
<!--------------Edit------------------>

            <div class="edit_cont container-fluid my-3 pb-3" id="panel2">
                  <h1 class="text-center pt-3">Edit Employee</h1>
                        <div class="search-container text-center">
                              <form method="post" action="edit.php?act=edit">
                                    <input type="text" placeholder="Search..." name="search">
                                    <button type="submit" name="save" onclick="showResault('resault')"><i class="fa fa-search m-3"></i></button>
                              </form>
                        </div>
            </div>

<!--------------Remove------------------>

            <div class="edit_cont container-fluid my-3 pb-3" id="panel3">
                  <h1 class="text-center pt-3">Remove Employee</h1>
                  <h3 class='text-center pt-3'>Try Removing Frank O!</h3>
                        <div class="search-container text-center">
                              <form method="post" action="edit.php?act=rem">
                                    <input type="text" placeholder="Search..." name="search">
                                    <button type="submit" name="save" onclick="showResault('resault')"><i class="fa fa-search m-3"></i></button>
                              </form>
                              
                        </div>
            </div>

<!--------------Post Div------------------>

            <?php
                  if(!empty($_POST['search'])){
                              echo'
                              <div class="edit_cont my-3 container-fluid pb-3">
                                    <div class="section my-3 container-fluid pb-3 " id="resault">
                                          <h1 class="text-center pt-3">Resault</h1>
                                                      <table class="table table-hover">
                                                            <thead>
                                                                  <tr class="bg-gradient text-center" style="background-color: #52b65b;">
                                                                        <th>Name</th>
                                                                        <th>Location</th>
                                                                        <th>Floor</th>
                                                                        <th>Cubicle #</th>
                                                                        <th>Action</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody>
                              ';         
                                    foreach($employeeDetails as $data){
                                          echo $data;
                                    }
                              echo"
                                                            </tbody>

                                                      </table>
                                    </div>
                              </div>
                              ";
                        }
            ?>

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