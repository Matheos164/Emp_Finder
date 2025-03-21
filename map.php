<?php
      session_start();
      require('connect.php');
      $floor = '';
      $map = '';
      $searchErr = '';
      $employeeDetails = '';
      $location = $_GET['loc'];


      if(isset($_POST['save'])){      
            if(!empty(trim($_POST['search']))){
                  $name  = filter_input( INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);;
                  $query = "SELECT * FROM emp WHERE Name LIKE '%$name%' And Location = '$location';";
                  $stms = $dbh->prepare($query);
                  $result = $stms->execute();
                  $count = $stms->rowCount();

                  if($count >= 1){
                        while($row = $stms->fetch()){
                              $employeeDetails = "<tr style='text-align:center' >
                                                      <td>{$row['Name']}</td>
                                                      <td>{$row['Location']}</td>
                                                      <td>{$row['Floor']}</td>
                                                      <td>{$row['Cubical']}</td>
                                                </tr>";
                              $floor = $row['Floor'];

                        }
                  }else{
                        $searchErr = "No Employee Found!";
                  }
            }else{
                  $searchErr = "Field is empty!";
            }
      }

      if($location == "John"){
            //Map for John's office location
            if($floor == 2){
                  $map = '<div id="floorplan" class="edit_cont my-3 container-fluid pb-3 ">
                              <img src="john\john-2nd.png" alt="FloorMap" id="FloorMap" class="">
                        </div>';
            }elseif($floor == 3){
                  $map = '<div id="floorplan" class="edit_cont my-3 container-fluid pb-3 ">
                              <img src="john\John-3rd.png" alt="FloorMap" id="FloorMap" class="">
                        </div>';
            }elseif($floor == 4){
                  $map = '<div id="floorplan" class="edit_cont my-3 container-fluid pb-3 ">
                              <img src="john\John-4th.png" alt="FloorMap" id="FloorMap" class="">
                        </div>';
            }elseif($floor == 5){
                  $map = '<div id="floorplan" class="edit_cont my-3 container-fluid pb-3 ">
                              <img src="john\john-5th.png" alt="FloorMap" id="FloorMap" class="">
                        </div>';
            }elseif($floor == 6){
                  $map = '<div id="floorplan" class="edit_cont my-3 container-fluid pb-3 ">
                              <img src="john\John-6th.png" alt="FloorMap" id="FloorMap" class="">
                        </div>';
            }else{
                  $map = '';
            }
      }elseif($location == "Nebo"){
            //Map for Nebo's office location
            if($floor == 1){
                  $map = '<div id="floorplan" class="edit_cont my-3 container-fluid pb-3 ">
                              <img src="Nebo\Nebo-1st.png" alt="FloorMap" id="FloorMap" class="">
                        </div>';
            }elseif($floor == 2){
                  $map = '<div id="floorplan" class="edit_cont my-3 container-fluid pb-3 ">
                              <img src="Nebo\Nebo-2nd.png" alt="FloorMap" id="FloorMap" class="">
                        </div>';
            }else{
                  $map = "";
            }
      }elseif($location == "Vansickle"){
            //Map for Vansickle's office location
            if($floor == 1){
                  $map = '<div id="floorplan" class="edit_cont my-3 container-fluid pb-3 ">
                              <img src="Vansickle\Vansickle-1st.png" alt="FloorMap" id="FloorMap" class="">
                        </div>';
            }elseif($floor == 2){
                  $map = '<div id="floorplan" class="edit_cont my-3 container-fluid pb-3 ">
                              <img src="Vansickle\Vansickle-2nd.png" alt="FloorMap" id="FloorMap" class="">
                        </div>';
            }else{
                  $map = "";
            }
      }else{
            echo 'Invalid Location';
      }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>

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
<!--------------Map------------------>

<main class="maps container-fluid d-flex flex-wrap">
      <div class="section my-3 container-fluid pb-3">
            <h1 class="text-center pt-3">Find Employee</h1>
            <h3 class='text-center pt-3'>Try Finding Tom Ford, Johnson Bell, and Danny T</h3>
            <div class="search-container text-center">
                  <form method="post" action="#">
                        <input type="text" placeholder="Search..." name="search">
                        <button type="submit" name="save" onclick="showResault('resault')"><i class="fa fa-search m-3"></i></button>
                  </form>
			<span class="error" style="color:red;"> <?php echo $searchErr;?></span>
            </div>
      </div>


      
      <?php
            if(!empty($_POST['search'])){
                        echo'
                        <div class="edit_cont my-3 container-fluid pb-3">
                              <div class="section my-3 container-fluid pb-3 " id="resault">
                                    <h1 class="text-center pt-3">Resault</h1>
                                          <div class="search-container text-center">
                                                <table class="table table-hover">
                                                      <thead>
                                                            <tr class="bg-gradient text-center" style="background-color: #9db314;">
                                                                  <th>Name</th>
                                                                  <th>Location</th>
                                                                  <th>Floor</th>
                                                                  <th>Cubicle #</th>
                                                            </tr>
                                                      </thead>
                        ';
                        echo"
                                                      <tbody>
                                                            $employeeDetails
                                                      </tbody>

                                                </table>
                                          </div>
                              </div>
                              </div>
                        ";
                  }

                  echo $map;
      ?>
      


</main>
<!---------------Footer----------------->

    <footer>
            <div id="copyright">
                  <span>Created Matheos Amanuel</span>
                  <br>
                  <span>From Mohawk College</span>
            </div>
    </footer>
</body>
</html>