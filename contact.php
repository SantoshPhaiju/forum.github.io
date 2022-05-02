    <?php include 'partials/_dbconnect.php'; ?>
    <?php 
    
    if(isset($_GET['loggedin']) && $_GET['loggedin'] == true){
        include 'partials/_header.php'; 
    }else{
        include 'partials/_header1.php';
    }
    ?>

    <style>
        .contheight {
            min-height: 80vh;
        }

    </style>
    <!-- <link rel="stylesheet" href="/forum/admin/style.css"> -->






<!-- Inserting form details in database -->

<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO `contact` (`fname`, `lname`, `subject`, `message`, `timestamp`) VALUES ('$fname', '$lname', '$subject', '$message', current_timestamp())";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your message is sent successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }

}



?>



    <!-- Here the form goes here to save the contact details. -->


    <div class="container contheight my-3">
        <h1 class="text-center">Contact Us</h1>
        <form action="/forum/contact.php" method="POST">
            <div class="row">
                <div class="col">
                    <input type="text" name="fname" id="fname" class="form-control form-control-lg" placeholder="First name">
                </div>
                <div class="col">
                    <input type="text" name="lname" id="lname" class="form-control form-control-lg" placeholder="Last name" >
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="text" name="subject" id="subject" class="form-control form-control-lg my-3" placeholder="Subject" >
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-floating">
                        <textarea class="form-control form-control-lg" name="message" placeholder="Leave a message here" id="message" style="height: 200px;"></textarea>
                        <label for="message" style="font-size: 18px; font-weight: bold;">Message</label>
                    </div>
                </div>
            </div>
            <button class="btn buttonCall mt-3">
                Send Message
            </button>
        </form>
    </div>






    <?php include 'partials/_footer.php'; ?>

