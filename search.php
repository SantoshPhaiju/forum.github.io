    <?php include 'partials/_dbconnect.php'; ?>


    <?php 
    
    if(isset($_COOKIE['name']) && $_COOKIE['name'] == true){
        include 'partials/_header.php';
    }else{
        include 'partials/_header1.php';
    }

    // if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    //     include 'partials/_header.php';
    // }else{
    //     include 'partials/_header1.php';
    // }
    
    ?>

    <style>
        #main-container {
            min-height: 100vh;
        }
    </style>









    <!-- Search results starts here -->

    <div class="container my-3" id="main-container">
        <h1 class="py-3">Secarch result for: <em> "<?php echo $_GET['search']  ?>" </em> </h1>

        <?php


        $noresults = true;
        $query =  $_GET['search'];
        $sql = "SELECT * FROM `threads` WHERE thread_title LIKE '%$query%' OR thread_desc LIKE '%$query%'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];
            $url = "thread.php?threadid=". $thread_id;
            $noresults = false;

            // Display the search result
            echo '<div class="result">
                        <h3> <a href="'. $url .'" class="text-dark"> '. $title  .' </a></h3>
                        <p>'. $desc .'</p>
                 </div>';
        }

        if ($noresults){
            echo '<div class="container my-3">
            <div class="container-fluid bg-light text-dark p-5">
                <div class="container bg-light p-5">
                    <p class="display-5 fw-bold">No Results Found</p>
                    <p class="lead"> Suggestions:
                    <ul>
                    <li>Make sure that all words are spelled correctly.</li>
                    <li>Try different keywords.</li>
                    <li>Try more general keywords.</li>
                    <li>Try fewer keywords.</li>
                    </ul>
                     </p>
                  </div>
                 </div>
             </div>';
        }


        ?>

    </div>


    <?php include 'partials/_footer.php'; ?>


   