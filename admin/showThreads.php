<style>
    .cont {
        min-height: 89vh;
    }

    .delete {
        text-align: center;
    }

    .edit {
        text-align: center;
    }

    .table thead th {
        padding: 12px;
    }

    .table tbody td {
        padding: 12px;
    }
</style>

<?php
include '_header.php';
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header("location: index.php");
}


?>
<div id="admin-content">

    <div class="container cont">

        <div class="row my-3">



            <div class="col-md-10">
                <h1>All threads</h1>
            </div>
            
        </div>



        <?php

        include '_dbconnect.php';

        $limit = 5;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        if($_SESSION['role'] == '1'){
            $sql = "SELECT * FROM threads  LEFT JOIN adminuser ON threads.thread_user_id = adminuser.id LIMIT $offset, $limit";  
        }else{
            $sql = "SELECT * FROM threads  LEFT JOIN adminuser ON threads.thread_user_id = adminuser.id
            WHERE adminuser.id = {$_SESSION['userid']}
            LIMIT $offset, $limit";  
        }
        $result = mysqli_query($conn, $sql);

        echo "<table class='table table-dark table-hover table-striped my-3'>";
        echo "<thead class='table-dark'>
<th> Id </th>
            <th> Thread titile </th>
            <th> Thread Description </th>
            <th> Author </th>
            <th> Edit </th>
            <th> Delete </th>
            </thead>
            ";
        if (mysqli_num_rows($result)) {
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
            
        ?>

                <tr style="text-align: center; vertical-align: middle;">
                    <td class='id'><?php echo $row['thread_id'] ?></td>
                    <td><?php echo $row['thread_title'] ?></td>
                    <td><?php echo $row['thread_desc'] ?></td>
                    <td><?php echo $row['username'] ?></td>
                    <td class='edit'><a href="updateThread.php?id=<?php echo $row['thread_id'] ?>"><i class='fa fa-edit'></i></a></td>
                    <td class='delete'><a onClick="javascript:return confirm('are you sure you want to delete this?');" href="deleteThread.php?id=<?php echo $row['thread_id'] ?>"><i class='fa fa-trash-o'></i></a></td>
                </tr>

        <?php
            }
            echo "</tbody>";
        }
        
        echo "</table>";
        if(mysqli_num_rows($result) == 0){
            echo "<div style='color: #212529; margin: 40px auto; width: 1000px; background: #198754; height: 200px; font-weight: bold; font-size: 28px; text-align: center; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 2px 2px 10px 2px #182d23;'>No threads found.</div>";
        }


        ?>
        <?php

        $sql = "SELECT * FROM threads";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)) {
            $total_records = mysqli_num_rows($result);
            $total_pages = ceil($total_records / $limit);


            echo '<nav aria-label="Page navigation example">';
            echo ' <ul class="pagination justify-content-center">';
            if($page > 1){
                echo '<li class="page-item"><a class="page-link" href="showThreads.php?page='. ($page - 1) .'" tabindex="-1" aria-disabled="true">Previous</a></li>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($page == $i) {
                    $active = "active";
                } else {
                    $active = "";
                }
                echo '<li class="page-item ' . $active . '"><a class="page-link" href="showThreads.php?page=' . $i . '">' . $i . '</a></li>';
            }
            if($page < $total_pages){
                echo '<li class="page-item"><a class="page-link" href="showThreads.php?page='. ($page + 1) .'" tabindex="-1" aria-disabled="true">Next</a></li>';
            }

            echo ' </ul>
           </nav>';
        }

        ?>
    </div>
</div>

<?php

include '_footer.php';

?>