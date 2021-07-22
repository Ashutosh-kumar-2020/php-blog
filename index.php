<?php

include 'includes/_db_connect.php';

if (!(isset($_GET['page']))) {
    header("Location: /ashu-net/index.php?page=1");
}


?>

<?php include "includes/_header.php";  ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <title><?php echo $settings['blog_name'];  ?></title>
</head>

<style>
    .pagination {
        display: flex;
        text-decoration: none;
        list-style: none;
        padding: 12px;
        justify-content: center;
    }

    .active {
        background-color: #ecfb0c;
    }
    .content
    {
        height: auto;
        background-color: #eadede;
    }
</style>

<style>
@media screen and (max-width: 1200px) {
    .content
    {
        height: auto;
    }
}
</style>

<body>
    <div class="max-width-1 m-auto">
        <hr>
    </div>
    <div class="m-auto content max-width-1 my-2">
        <div class="content-left">
            <h1>Welcome To <?php echo $settings['blog_name'];  ?></h1>
            <p><?php echo $settings['blog_desc'];  ?></p>
        </div>
        <div class="content-right">
            <img src="img/home.svg" alt="iBlog">
        </div>
    </div>

    <div class="max-width-1 m-auto">
        <hr>
    </div>
    <div class="home-articles max-width-1 m-auto font2">
        <h2>Recent Posts<?php

                        if ($_GET['page'] > 1) {
                            echo " - Page " . $_GET['page'];
                        }

                        ?></h2>
        <?php

        $limit = $settings['blog_page_limit'];
        $page = $_GET['page'];
        $offset = ($page - 1) * $limit;


        $getPosts = "SELECT * FROM `ashu_net`.`posts` ORDER BY `post_id` DESC LIMIT $offset, $limit";
        $stmt = $dbconn->query($getPosts);

        $num_rows = $stmt->rowCount();

        if (!($num_rows > 0)) {
            echo " <script type='text/javascript'> ";
            $message = "This Page deos not exists !";
            echo ' window.alert("' . $message . '"); ';
            echo ' window.location.replace("/ashu-net/index.php"); ';
            echo " </script> ";
        }

        while ($result = $stmt->fetch()) {
            $post_id = $result['post_id'];
            $post_title = $result['post_title'];
            $post_username = $result['post_username'];
            $post_datetime = $result['post_datetime'];
            $post_img = $result['post_img'];

            $posted_on = date('F jS Y', strtotime($post_datetime));

            if($post_img == "" or $post_img == "blog_img/")
            {
                echo '<div class="home-article">
                        <div class="home-article-img">
                            <img src="img/3.png" alt="article">
                        </div>
                        <div class="home-article-content font1">
                            <a href="post.php?post_id=' . $post_id . '">
                                <h3>' . $post_title . '</h3>
                            </a>
            
                            <div>Author :- ' . $result['post_username'] . '</div>
                            <span>' . $posted_on . ' | ' . $result['post_views'] . ' Views

                            </span> 

                        </div>
                    </div>
                    
                    <hr>';
            }
            else
            {
                echo '<div class="home-article">
                <div class="home-article-img">
                    <img height="200" width="300" src="admin/blog_img/' . $post_img .'" alt="article">
                </div>
                <div class="home-article-content font1">
                    <a href="post.php?post_id=' . $post_id . '">
                        <h3>' . $post_title . '</h3>
                    </a>
    
                    <div>Author :- ' . $result['post_username'] . '</div>
                    <span>' . $posted_on . ' | ' . $result['post_views'] . ' Views

                    </span> 

                </div>
            </div>
            
            <hr>';
            }
        }

        ?>

        <?php

        $pagination_sql = "SELECT * FROM `ashu_net`.`posts`";
        $pagination_stmt = $dbconn->query($pagination_sql);

        $pagination_num_rows = $pagination_stmt->rowCount();

        $total_pages = ceil($pagination_num_rows / $limit);

        echo '<ul class="pagination">';
        $next = $page + 1;
        $prev = $page - 1;

        if ($page > 1) {
            echo '<a href="/ashu-net/index.php?page=' . $prev . '"><button class="btn">Prev</button></a>';
        }


        if ($total_pages > $page) {
            echo '<a href="/ashu-net/index.php?page=' . $next . '"><button style="    margin-left: 12px;" class="btn">Next</button></a>';
        }
        echo '</ul>';



        ?>


    </div>

    <?php include "includes/_footer.php";   ?>

</html>
