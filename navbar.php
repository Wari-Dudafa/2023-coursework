<?php
    // Sets the navbar as a massive sting
    $navbar = array('
        <div class="top_navbar">
            <nav class="navbar navbar-inverse" style="background-color: #002f63;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="homepage.php"><img src="BranchLogo.png" alt="icon" width="45" height="45"></a> 
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>',
                            // Display username
                            '<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form class="navbar-form navbar-left" action="searchresults.php" method="post">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search branch..." name="search">
                                            <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                            </div>
                                        </div>
                                </form>
                                </li>
                                <!--The icons in the drop down menu-->
                                <li><a href="upload.php"> <span class="glyphicon glyphicon-upload"></span> Upload</a></li>
                                <li><a href="likedvideos.php"> <span class="glyphicon glyphicon-thumbs-up"></span> Liked videos</a></li>
                                <li><a href="logout.php"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    ');

    //echo $navbar;
?>
