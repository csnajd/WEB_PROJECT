<?php
include "db.php";

$id = $_GET['id'];

$sql = "SELECT * FROM places WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html> <!-- to be replaced with header.php -->
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>Discover Saudi Arabia</title>
    </head>
    <body>
        <h1><?php echo $row['name']; ?></h1>

        <h2>الصورة الرئيسية</h2>
        <img src="<?php echo $row['main_image']; ?>" alt="">

        <h2>الموقع</h2>
        <p><?php echo $row['type']; ?></p>

        <h2>معلومات تاريخية</h2>
        <p><?php echo $row['historical_info']; ?></p>

        <h2>معلومات ثقافية</h2>
        <p><?php echo $row['cultural_info']; ?></p>

        <h2>أهم المعالم</h2>
        <p><?php echo $row['landmarks']; ?></p>

        <?php
        $images = [];
        // add images to slider if not null
        if (!empty($row['extra_image1'])) {
            $images[] = $row['extra_image1'];
        }
        if (!empty($row['extra_image2'])) {
            $images[] = $row['extra_image2'];
        }
        if (!empty($row['extra_image3'])) {
            $images[] = $row['extra_image3'];
        }
        ?>

        <!-- if no extra images, the following block of code is skipped -->
        <?php if (count($images) === 1) { ?>
        <h2>صورة إضافية</h2>
        <div class="extra-images">
            <img src="<?php echo $images[0]; ?>" alt="">
        </div>
        <?php } elseif (count($images) > 1) { ?> <!-- only include slider if there's more than 1 extra image -->
        <h2>صور إضافية</h2>
        <div class="slider" data-images='<?php echo json_encode($images); ?>'> <!-- json_encode turns php $images array into a js array -->
            <button onclick="prevImage()">‹</button>
            <img id="sliderImage" src="<?php echo $images[0]; ?>" alt="">
            <button onclick="nextImage()">›</button>
        </div>
        <?php } ?>

        <script src="js/slider.js"></script>
    </body> <!-- to be replaced with footer.php -->
</html>