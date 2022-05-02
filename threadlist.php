<?php include 'partials/_dbconnect.php'; ?>
<?php
if (isset($_GET['loggedin']) && $_GET['loggedin'] == true) {
    include 'partials/_header.php';
} else {
    include 'partials/_header1.php';
}
?>

<style>
    #ques {
        min-height: 400px;
    }

    .anchor {
        margin: 5px;
        padding: 0px;
        font-weight: bold;
        font-size: 20px;
    }
</style>

<?php
$id = $_GET['catid'];
$sql = 'SELECT * FROM `categories` WHERE category_id=' . $id . '';
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $catname = $row['category_name'];
    $catdesc = $row['category_description'];
}


?>

<?php
$showAlert = false;
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {
    // Insert into thread db
    $th_title = $_POST['title'];
    $th_desc = $_POST['desc'];

    $th_title = str_replace("<", "&lt;", $th_title);
    $th_title = str_replace(">", "&gt;", $th_title);

    $th_desc = str_replace("<", "&lt;", $th_desc);
    $th_desc = str_replace(">", "&gt;", $th_desc);

    $sno = $_POST["sno"];
    $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
    $result = mysqli_query($conn, $sql);
    $showAlert = true;

    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success! </strong> Your thread has been edit! Please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
}



?>






<div class="container my-3">
    <div class="container-fluid bg-light text-dark p-5">
        <div class="container bg-light p-5">
            <h1 class="display-4 fw-bold ">Welcome to <?php echo $catname; ?> Forums</h1>
            <p><?php echo $catdesc; ?></p>
            <hr>
            <p>This is the peer to peer forums where you can put the question realted to the problems while coding.
                Forum Rules:
                No Spam / Advertising / Self-promote in the forums.
                Do not post copyright-infringing material,
                Do not post “offensive” posts, links or images,
                Do not cross post questions,
                Do not PM users asking for help,
                Remain respectful of other members at all times.
            </p>
            <a href="#" class="btn btn-primary">Learn More</a>
        </div>
    </div>
</div>


<?php

if (isset($_SESSION['loggedin'])  && $_SESSION['loggedin'] == true) {
    echo   ' <div class="container">
    <h1 class="py-3">Start a discussion</h1>

   <form action="' . $_SERVER["REQUEST_URI"] . '" method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Problem title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="title">
            <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible.</div>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Elaborate your concern</label>
            <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            <input type="hidden" name="sno" value="' . $_SESSION["userid"] . '">
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>';
} else {
    echo '
        <div class="container">
        <h1 class="py-3">Start a discussion</h1>
        <p class="lead">You are not logged in. Please login to be able to start a discussion.</p>
    </div>';
}


?>



<div class="container" id="ques">
    <h1 class="py-3">Browse Questions</h1>

    <?php

    // here writing the code of the pagination 
    $id = $_GET['catid'];
    $limit = 5;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }



    $offset = ($page - 1) * $limit;
    $sql = 'SELECT * FROM `threads` WHERE thread_cat_id=' . $id . ' LIMIT ' . $offset . ', ' . $limit . '';
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while ($row = mysqli_fetch_assoc($result)) {
        $noResult = false;
        $id = $row['thread_id'];
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_time = $row['timestamp'];
        $thread_user_id = $row['thread_user_id'];
        $sql2 = "SELECT username FROM `adminuser` WHERE id= '$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);




        echo '    <div class="d-flex my-3">
            <div class="flex-shrink-0">
                <img src="admin/upload/userdefault.png" width="66px" alt="Sample Image">
            </div>
            <div class="flex-grow-1 ms-3">';
        if (isset($_GET["loggedin"]) && $_GET["loggedin"] == true) {
            echo '<h5><a class=" text-decoration-none" href="thread.php?threadid=' . $id . '&loggedin=true">' . $title . '</a></h5>
                <p class="fw-bold my-0"> Asked by: ' . $row2['username'] . ' at ' . $thread_time . '</p>
                <p>' . $desc . '</p>';
        } else {
            echo '<h5><a class=" text-decoration-none" href="thread.php?threadid=' . $id . ' ">' . $title . '</a></h5>
                <p class="fw-bold my-0"> Asked by: ' . $row2['username'] . ' at ' . $thread_time . '</p>
                <p>' . $desc . '</p>';
        }


        echo  '</div>
        </div> ';
    }

    if ($noResult) {
        echo '<div class="container my-3">
            <div class="container-fluid bg-light text-dark p-5">
                <div class="container bg-light p-5">
                    <p class="display-5 fw-bold">No Threads Found</p>
                    <p><?php  echo $catdesc; ?></p>
        <p>Be the first person to ask the question.
        </p>
    </div>
    </div>
    </div>';
    }






    ?>


    <?php
    $id = $_GET['catid'];


    $sql = "SELECT * FROM threads where thread_cat_id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result)) {
        $total_records = mysqli_num_rows($result);
        $total_pages = ceil($total_records / $limit);

        echo '<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">';
        if ($page > 1) {
            echo '<li class="page-item"> <a class="page-link" href="threadlist.php?page=' . ($page - 1) . '&catid=' . $id . '" tabindex="-1" aria-disabled="true">Previous</a></li>';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            if ($page == $i) {
                $active = "active";
            } else {
                $active = "";
            }
            echo  '<li class="page-item ' . $active . '"><a class="page-link" href="threadlist.php?page=' . $i . '&catid=' . $id . '">' . $i . '</a></li>';
        }

        if ($page < $total_pages) {
            echo '<li class="page-item"> <a class="page-link" href="threadlist.php?page=' . ($page + 1) . '&catid=' . $id . '" tabindex="-1" aria-disabled="true">Next</a></li>';
        }


        echo '  </ul>
    </nav>';
    }

    ?>

</div>




<?php include 'partials/_footer.php'; ?>