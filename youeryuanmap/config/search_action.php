<? include ('conn.php') ?>
<?
    $subject = $_POST['topic'];
    if ($subject != ''){
        $search_sql = "select * from myMap where (id like '%" .$subject. "%') or (title like '%" .$subject. "%') or (address like '%" .$subject. "%') order by id,title,address";
        $search_result = mysqli_query($conn, $search_sql);
        while ($row = $search_result->fetch_assoc()) {
            echo '<li onmouseover="openMyWin(infoWindow'.$row["id"].',point['.$row["id"].'])" >
                            <a href="#">'.$row['title'].'</a>
                        </li>';
        }
    } else {
        echo "none result";
    }
?>
