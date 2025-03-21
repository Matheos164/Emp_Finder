
<?php
      session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

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
<!--------------Locations------------------>
<main class="buildings container-fluid d-flex flex-wrap">
      
      <div class="location my-3 container-fluid pb-3">
            <h1 class="text-center pt-3">Nebo Rd</h1>
            <form action="map.php?loc=Nebo" method="post">
                  <input type="image" value="Nebo_Loc" name="nebo" class="place-img " src="pics/Nebo.png" alt="Nebo" width="850" height="550">
            </form>
      </div>
      <!-------------------------------->
      <div class="location my-3 container-fluid pb-3 ">
            <h1 class="text-center pt-3">John St</h1>
            <form action="map.php?loc=John" method="post">
                  <input type="image" value="John_Loc" name="john" class="place-img " src="pics/John.png" alt="John " width="850" height="550">
            </form>
                  
      </div>
      
      <!-------------------------------->
      <div class="location my-3 container-fluid pb-3">
            <h1 class="text-center pt-3">Vansickle Rd</h1>
            <form action="map.php?loc=Vansickle" method="post">
                  <input type="image" value="Vansickle_Loc" name="vansickle" class="place-img " src="pics/Vansickle.png" alt="Vansickle" width="850" height="550">
            </form>
      </div>
      
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