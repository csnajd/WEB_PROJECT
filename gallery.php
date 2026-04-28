<?php
include "db.php";

$sql = "SELECT * FROM places";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html> <!-- to be replaced with header.php -->
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>Discover Saudi Arabia</title>
    </head>
    <body>
        <input type="text" id="searchInput" placeholder="ابحث...">
        <select id="categoryFilter">
            <option value="all">الكل</option>
            <option value="منطقة الرياض">منطقة الرياض</option>
            <option value="منطقة مكة المكرمة">منطقة مكة المكرمة</option>
            <option value="منطقة المدينة المنورة">منطقة المدينة المنورة</option>
            <option value="منطقة عسير">منطقة عسير</option>
            <option value="منطقة تبوك">منطقة تبوك</option>
        </select>

        <p id="resultsCount"></p>

        <div class="gallery">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="card" data-type="<?php echo $row['type']; ?>">
                <img src="<?php echo $row['main_image']; ?>" alt="">
                <h1><?php echo $row['name']; ?></h1>
                <p><?php echo $row['description']; ?></p>
                <a href="details.php?id=<?php echo $row['id'];?>">عرض التفاصيل</a>
            </div>
        <?php } ?>   
        </div>

        <script src="js/filter.js"></script>
    </body> <!-- to be replaced with footer.php -->
</html>