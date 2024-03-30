<?php
include('res/dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./res/style.css">
    <title>SiteScape</title>
</head>

<body>
    <!-- sidebar content -->
    <div class="sidebar">
        <ul class="nav-links">
            <li class="active">
                <i class="bx bx-grid-alt"></i>
                <span class="links_name">All Sites</span>
            </li>
            <?php
            $sql = "SELECT DISTINCT category_name, category_id FROM categories";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                    <li>
                        <i class="bx bx-box"></i>
                        <span class="links_name">
                            <?php echo htmlentities($result->category_name); ?>
                        </span>
                    </li>
                <?php }
            } ?>
        </ul>
    </div>

    <!-- Page content -->
    <div class="content">
        <!-- all Sites -->
        <div class="tab active">
            <?php
            // Fetch all categories
            $sqlCategories = "SELECT * FROM categories";
            $queryCategories = $dbh->prepare($sqlCategories);
            $queryCategories->execute();
            $categories = $queryCategories->fetchAll(PDO::FETCH_OBJ);

            // Loop through each category
            foreach ($categories as $category) { ?>
                <h2>
                    <?php echo htmlentities($category->category_name); ?>
                </h2>
                <div class="sites-container">
                    <?php
                    // Fetch sites belonging to the current category
                    $categoryId = $category->category_id;
                    $sqlSites = "SELECT * FROM sites WHERE category_id = :category_id";
                    $querySites = $dbh->prepare($sqlSites);
                    $querySites->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
                    $querySites->execute();
                    $sites = $querySites->fetchAll(PDO::FETCH_OBJ);

                    // Display each site
                    $siteCount = 0;
                    foreach ($sites as $site) {
                        // Check if it's the first site in a row
                        if ($siteCount % 5 == 0) {
                            echo '<div class="row">';
                        } ?>
                        <div class="site" href="<?php echo htmlentities($site->site_link); ?>">
                            <img src="./images/<?php echo htmlentities($site->site_image); ?>" alt="Site Icon">
                            <p>
                                <?php echo htmlentities($site->site_name); ?>
                            </p>
                            <p>
                                <span>
                                    <?php echo htmlentities($site->site_company); ?>
                                </span>
                            </p>
                        </div>
                        <?php
                        // Check if it's the last site in a row or the last site overall
                        if (($siteCount + 1) % 5 == 0 || $siteCount == count($sites) - 1) {
                            echo '</div>'; // Close the row div
                        }
                        $siteCount++;
                    } ?>
                </div>
            <?php } ?>
        </div>

        <!-- devided by CategoryName -->
        <?php
        $sqlCategories = "SELECT DISTINCT category_name, category_id FROM categories";
        $queryCategories = $dbh->prepare($sqlCategories);
        $queryCategories->execute();
        $categories = $queryCategories->fetchAll(PDO::FETCH_OBJ);
        if ($queryCategories->rowCount() > 0) {
            foreach ($categories as $category) {
                ?>
                <div class="tab <?php echo $category->category_name; ?>">
                    <h2>
                        <?php echo htmlentities($category->category_name); ?>
                    </h2>
                    <div class="sites-container"> <!-- Added container for sites -->
                        <?php
                        $categoryId = $category->category_id;
                        $sqlSites = "SELECT * FROM sites WHERE category_id = :category_id";
                        $querySites = $dbh->prepare($sqlSites);
                        $querySites->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
                        $querySites->execute();
                        $sites = $querySites->fetchAll(PDO::FETCH_OBJ);
                        if ($querySites->rowCount() > 0) {
                            $siteCount = 0; // Counter to determine the number of sites per row
                            foreach ($sites as $site) {
                                if ($siteCount % 5 == 0) { // Start a new row for every 5 sites
                                    echo '<div class="row">';
                                }
                                ?>

                                <div class="site" href="<?php echo htmlentities($site->site_link); ?>">
                                    <img src="./images/<?php echo htmlentities($site->site_image); ?>" alt="Site Icon">
                                    <p>
                                        <?php echo htmlentities($site->site_name); ?>
                                    </p>
                                    <p>
                                        <span>
                                            <?php echo htmlentities($site->site_company); ?>
                                        </span>
                                    </p>
                                </div>
                                <?php
                                $siteCount++;
                                if ($siteCount % 5 == 0) { // Close the row after every 5 sites
                                    echo '</div>';
                                }
                            }
                            // Close the row if it's not filled with 5 sites
                            if ($siteCount % 5 != 0) {
                                echo '</div>';
                            }
                        } ?>
                    </div>
                </div>
            <?php }
        } ?>
    </div>

    <!-- JavaScript for tab navigation -->
    <script>
        // Get all tab buttons
        var tabButtons = document.querySelectorAll('.nav-links li');

        // Get all tab contents
        var tabContents = document.querySelectorAll('.tab');

        // Add click event listener to each tab button
        tabButtons.forEach(function (button, index) {
            button.addEventListener('click', function () {
                // Remove 'active' class from all tab buttons and contents
                tabButtons.forEach(function (btn) {
                    btn.classList.remove('active');
                });
                tabContents.forEach(function (content) {
                    content.classList.remove('active');
                });

                // Add 'active' class to the clicked tab button
                this.classList.add('active');

                // Display the corresponding tab content based on its index
                tabContents[index].classList.add('active');
            });
        });

        // Add click event listener to each .site element
        var siteElements = document.querySelectorAll('.site');
        siteElements.forEach(function (site) {
            site.addEventListener('click', function (event) {
                // Prevent the default action of the click event
                event.preventDefault();
                // Get the href attribute of the clicked site
                var href = this.getAttribute('href');
                // If the href is not null or empty, open it in a new tab
                if (href && href.trim() !== '') {
                    window.open(href, '_blank');
                }
            });
        });
    </script>
</body>

</html>