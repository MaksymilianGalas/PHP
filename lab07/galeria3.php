<!DOCTYPE html>
<html>
<head>
    <title>Gallery</title>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .gallery img {
            max-width: 200px;
            margin: 10px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .pagination button {
            margin: 0 5px;
        }
    </style>
</head>
<body>

<h1>Gallery</h1>

<div class="gallery">

    <?php
    $dir = 'image/thumbnails';
    $images = glob($dir . '/*.jpg');


    $images_per_page = 4;


    $num_pages = ceil(count($images) / $images_per_page);


    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


    $start = ($page - 1) * $images_per_page;


    $page_images = array_slice($images, $start, $images_per_page);


    foreach ($page_images as $image) {
        $fullsize_image = 'image/fullsize/' . basename($image);
        echo '<a href="' . $fullsize_image . '"><img src="' . $image . '"></a>';
    }
    ?>

</div>

<div class="pagination">
    <?php
    if ($num_pages > 1) {
        if ($page > 1) {
            echo '<button><a href="?page=' . ($page - 1) . '">Previous</a></button>';
        }

        for ($i = 1; $i <= $num_pages; $i++) {
            if ($i == $page) {
                echo '<button><strong>' . $i . '</strong></button>';
            } else {
                echo '<button><a href="?page=' . $i . '">' . $i . '</a></button>';
            }
        }

        if ($page < $num_pages) {
            echo '<button><a href="?page=' . ($page + 1) . '">Next</a></button>';
        }
    }
    ?>
</div>

</body>
</html>
