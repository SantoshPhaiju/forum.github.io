
    <style>
        #ques{
            min-height: 433px;
        }
    </style>


    <?php 
    $showAlert = false;
    
    include 'partials/_dbconnect.php'; ?>
    <?php 
    
    if(isset($_GET['loggedin']) && $_GET['loggedin'] == true){
        include 'partials/_header.php'; 
        if(!empty($_SESSION['showAlert'])){
            echo $_SESSION['showAlert'];
            unset($_SESSION['showAlert']);
        }
        
    //     echo $showAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //     <strong>Success! </strong> You are loggedin!
    //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //   </div>';
        
    }else{
        include 'partials/_header1.php';
        
    }
    if(isset($_COOKIE['Error'])){
        echo $_COOKIE["Error"];

    }
    if(isset($_COOKIE['logout'])){
        echo $_COOKIE["logout"];
    }
    if(isset($_COOKIE['change'])){
        echo $_COOKIE["change"];
    }
    if(!empty($_SESSION['signedup'])){
        echo $_SESSION["signedup"];
        unset($_SESSION['signedup']);
    }
    
    ?>
    

    <!-- slider starts here -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="admin/upload/slider-1.jfif" width="2400" height="550" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="admin/upload/slider-2.jfif" width="2400" height="550" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="admin/upload/slider-3.jfif" width="2400" height="550" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Category container starts here -->
    <div class="container my-3" id="ques">
        <h2 class="text-center my-3">iDiscuss - Browse Categories</h2>
        <div class="row my-3">

            <!-- Fetch all the categories and use a while  loop to iterate through categories -->

            <?php
      $sql = 'SELECT * FROM `categories`';
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['category_id'];
        $cat = $row['category_name'];
        $desc = $row['category_description'];
        echo ' <div class="col-md-4 my-3">
                <div class="card" style="width: 20rem;">
                <img src="/forum/admin/upload/'. $row['category_img'] .'" height="250px" width: 100%;>
                    <div class="card-body">
                        <h5 class="card-title"><a href="threadlist.php?catid='. $id . '">' . $cat . ' </a></h5>
                        <p class="card-text">' . substr($desc, 0, 150) . '...</p>';
                        if(isset($_GET["loggedin"]) && $_GET["loggedin"] == true){
                            echo '<a href="threadlist.php?catid='. $id . '&loggedin=true" class="btn btn-primary">View Threads</a>';
                        }else{
                            echo '<a href="threadlist.php?catid='. $id . '" class="btn btn-primary">View Threads</a>';
                        }
                    echo '</div>
                </div>
            </div>';
      }
      ?>

        </div>
    </div>

    <?php include 'partials/_footer.php'; ?>


   