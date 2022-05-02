    <?php include 'partials/_dbconnect.php'; ?>
    <?php 
       if(isset($_GET['loggedin']) && $_GET['loggedin'] == true){
        include 'partials/_header.php'; 
        
    }else{
        include 'partials/_header1.php';
    }
     ?>

    <style>
        #ques {
            min-height: 400px;
        }
    </style>



    <?php
    $id = $_GET['threadid'];
    $sql = 'SELECT * FROM `threads` WHERE thread_id=' . $id . '';
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];

        // Query the user table to find out the Original Poster
        $sql2 = "SELECT username FROM `adminuser` WHERE id= '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['username'];
    }


    ?>


    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        // Insert into comment  db
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);
        $sno = $_POST["sno"];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno' , current_timestamp());
        ";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;

        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success! </strong> Your comment has been added!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }



    ?>





    <div class="container my-3">
        <div class="container-fluid bg-light text-dark p-5">
            <div class="container bg-light p-5">
                <h1 class="display-4 fw-bold "><?php echo $title; ?></h1>
                <p><?php echo $desc; ?></p>
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
                <p class="text-left">Posted by: <em> <?php  echo $posted_by ?></em></p>
            </div>
        </div>
    </div>

    <?php
    if (isset($_SESSION['loggedin'])  && $_SESSION['loggedin'] == true) {
        echo ' <div class="container">
        <h1 class="py-3">Post a comment</h1>
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'. $_SESSION["userid"] .'">

            </div>
            <button type="submit" class="btn btn-success">Post comment</button>
        </form>
    </div>';
    } else {
        echo '
    <div class="container">
    <h1 class="py-3">Post a comment</h1>

    <p class="lead">You are not logged in. Please login to be able to post a comment.</p>
</div>';
    }
    ?>



    <div class="container" id="ques">
        <h1 class="py-3">Discussions</h1>

        <?php
        $id = $_GET['threadid'];
        $sql = 'SELECT * FROM `comments` WHERE thread_id=' . $id . '';
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];

            $sql2 = "SELECT username FROM `adminuser` WHERE id= '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);




            echo '    <div class="d-flex my-3">
            <div class="flex-shrink-0">
                <img src="admin/upload/userdefault.png" width="66px" alt="Sample Image">
            </div>
            <div class="flex-grow-1 ms-3">
            <p class="fw-bold my-0"> '. $row2['username'] .' at ' . $comment_time . '</p>
                <p>' . $content . '</p>
            </div>
        </div> ';
        }

        if ($noResult) {
            echo '<div class="container my-3">
            <div class="container-fluid bg-light text-dark p-5">
                <div class="container bg-light p-5">
                    <p class="display-5 fw-bold">No Comments Found</p>
                    <p><?php  echo $catdesc; ?></p>
        <p>Be the first person to ask the question.
        </p>
    </div>
    </div>
    </div>';
        }


        ?>






    </div>



<?php include 'partials/_footer.php'; ?>