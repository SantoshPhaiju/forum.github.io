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
<?php

if(isset($_SESSION["role"]) && $_SESSION['role'] == 0){

    // header("location: showCategory.php");
    echo("<script>location.href = 'users.php';</script>");
} 

?>
<?php
if(!empty($_SESSION['log'])){
    echo $_SESSION['log'];
    unset($_SESSION['log']);
}
?>
<div id="admin-content">

    <div class="container cont">

        <div class="row my-3">



            <div class="col-md-10">
                <h1>All categories</h1>
            </div>
            <div class="col-md-2">
                <a href="addCategory.php" class="btn btn-primary">ADD CATEGORY</a>
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


        $sql = "SELECT * FROM categories LIMIT $offset, $limit";
        $result = mysqli_query($conn, $sql);

        echo "<table class='table table-dark table-hover table-striped my-3'>";
        echo "<thead class='table-dark'>
            <th> Id </th>
            <th> Name </th>
            <th> Description </th>
            <th> Image </th>
            <th> Edit </th>
            <th> Delete </th>
            </thead>
            ";
        if (mysqli_num_rows($result)) {
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
?>

                <tr style="text-align: center; vertical-align: middle;">
                    <td class='id'><?php echo $row['category_id'] ?></td>
                    <td><?php echo $row['category_name'] ?></td>
                    <td><?php echo $row['category_description'] ?></td>
                    <td> <img src="upload/<?php echo $row['category_img'] ?>" style="height: 150px; width: 150px;" alt=""></td>
                    <td class='edit'><a href="updateCategory.php?id=<?php echo $row['category_id'] ?>"><i class='fa fa-edit'></i></a></td>
                    <td class='delete'><a onClick="javascript:return confirm('are you sure you want to delete this?');" href="delete-category.php?id=<?php echo $row['category_id'] ?>"><i class='fa fa-trash-o'></i></a></td>
                </tr>

<?php
            }
            echo "</tbody>";
        }
        echo "</table>";

        
        

        $sql = "SELECT * FROM categories";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)) {
            $total_records = mysqli_num_rows($result);
            $total_pages = ceil($total_records / $limit);


            echo '<nav aria-label="Page navigation example">';
            echo ' <ul class="pagination justify-content-center">';
            if($page > 1){
                echo '<li class="page-item"><a class="page-link" href="showCategory.php?page='. ($page - 1) .'" tabindex="-1" aria-disabled="true">Previous</a></li>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($page == $i) {
                    $active = "active";
                } else {
                    $active = "";
                }
                echo '<li class="page-item ' . $active . '"><a class="page-link" href="showCategory.php?page=' . $i . '">' . $i . '</a></li>';
            }
            if($page < $total_pages){
                echo '<li class="page-item"><a class="page-link" href="showCategory.php?page='. ($page + 1) .'" tabindex="-1" aria-disabled="true">Next</a></li>';
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