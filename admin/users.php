<?php
include '_header.php';
if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
    header("location: index.php");
}

if (!empty($_SESSION['log'])) {
    echo $_SESSION['log'];
    unset($_SESSION['log']);
}
?>

<div id="admin-content">
    <div class="container cont">
        <div class="row my-3">
            <div class="col-md-10">
                <h1>All Users</h1>
            </div>
            <?php
            if ($_SESSION['role'] == 1) {
                echo '<div class="col-md-2">
                        <a href="addUser.php" class="btn btn-primary">ADD USERS</a>
                    </div>';
            }
            ?>
        </div>

        <?php

        include '_dbconnect.php';

        if (isset($_GET['error']) && $_GET['error'] == true) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> User is 2 or less than two so you can\'t delete the users further.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }


        $limit = 5;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;
        if ($_SESSION['role'] == '1') {
            $sql = "SELECT * FROM adminuser LIMIT $offset, $limit";
        } elseif ($_SESSION['role'] == '0') {
            $sql = "SELECT * FROM adminuser WHERE id = $userid";
        }



        $result = mysqli_query($conn, $sql);
        echo "<table class='table table-dark table-hover table-striped my-3'>";
        echo "<thead class='table-dark'>
            <th> Id </th>
            <th> Name </th>
            <th> UserName </th>
            <th> Email </th>
            <th> Role </th>
            <th> Image </th>
            <th> Edit </th>
            <th> Delete </th>
            </thead>
            ";
        if (mysqli_num_rows($result)) {
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
        ?>

                <tr style="text-align: center; vertical-align: middle; ">
                    <td class='id'><?php echo $row['id'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['username'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php

                        if ($row['role'] == 1) {
                            echo "Admin";
                        } else {
                            echo "Normal User";
                        }


                        ?></td>
                    <td> <img src="upload/<?php echo $row['user_image'] ?>" style="height: 150px; width: 150px;" alt=""> </td>
                    <td class='edit'><a href="updateUser.php?userid=<?php echo $row['id'] ?>"><i class='fa fa-edit'></i></a></td>
                    <td class='delete'><a onClick="javascript:return confirm('are you sure you want to delete this?');" href="deleteUser.php?userid=<?php echo $row['id'] ?>"><i class='fa fa-trash-o'></i></a></td>
                    <!-- <script>
                        function confirmationDelete(anchor) {
                            var conf = confirm('Are you sure want to delete this record?');
                            if (conf)
                                window.location = anchor.attr("href");
                        
                        }
                    </script> -->

                </tr>

        <?php
            }
            echo "</tbody>";
        }
        echo "</table>";



        ?>

        <!-- pagination -->
        <?php

        if ($_SESSION['role'] == '1') {
            $sql = "SELECT * FROM adminuser";
        } elseif ($_SESSION['role'] == '0') {
            $sql = "SELECT * FROM adminuser WHERE id = $userid";
        }
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result)) {
            $total_records = mysqli_num_rows($result);
            $total_pages = ceil($total_records / $limit);

            echo '<nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">';
            if ($page > 1) {
                echo '<li class="page-item"> <a class="page-link" href="users.php?page=' . ($page - 1) . '" tabindex="-1" aria-disabled="true">Previous</a></li>';
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($page == $i) {
                    $active = "active";
                } else {
                    $active = "";
                }
                echo  '<li class="page-item ' . $active . '"><a class="page-link" href="users.php?page=' . $i . '">' . $i . '</a></li>';
            }

            if ($page < $total_pages) {
                echo '<li class="page-item"> <a class="page-link" href="users.php?page=' . ($page + 1) . '" tabindex="-1" aria-disabled="true">Next</a></li>';
            }


            echo '  </ul>
            </nav>';
        }

        ?>

    </div>



</div>



<?php

include '_footer.php';
?>