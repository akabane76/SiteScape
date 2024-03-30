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
            <li class="">
                <i class="bx bx-grid-alt"></i>
                <span class="links_name">All Sites</span>
            </li>
            <li class="">
                <i class="bx bx-grid-alt"></i>
                <span class="links_name">All Sites</span>
            </li>
        </ul>
    </div>

    <!-- Page content -->
    <div class="content">
        <!-- all Sites -->
        <div class="tab active">

            <h2>
                AI Site
            </h2>
            <div class="sites-container">
                <div class="row">
                    <div class="site" href="messenger.com">
                        <img src="./images/123.png" alt="Site Icon">
                        <p>
                            site_name
                        </p>
                        <p>
                            <span>
                                site_company
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- devided by CategoryName -->
        <div class="tab">

            <h2>
                AI Site
            </h2>
            <div class="sites-container">
                <div class="row">
                    <div class="site" href="messenger.com">
                        <img src="./images/123.png" alt="Site Icon">
                        <p>
                            site_name
                        </p>
                        <p>
                            <span>
                                site_company
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
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