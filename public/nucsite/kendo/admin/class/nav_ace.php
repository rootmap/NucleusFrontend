<?php if($status==4){ ?>
<ul class="nav ace-nav">
	<li class="green">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="icon-envelope icon-animated-vertical"></i>
            <span class="badge badge-success">
			Online Servey <?php echo getrowstotal("online_servey"); ?>
            </span>
        </a>

        <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
            <li class="dropdown-header">
                <a href="onlineservey.php">
                <i class="icon-envelope-alt"></i>
                List Of Servey
                </a>
            </li>

        </ul>
    </li>
    <li class="purple">
        <a href="setbreakingnews.php">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Breaking News </span>
        </a>
    </li>
    
    <li class="purple">
        <a href="topsix.php">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Top Six </span>
        </a>
    </li>
    
    <li class="purple">
        <a  href="#" data-toggle="dropdown" class="dropdown-toggle">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Gallery Data</span>
        </a>
        <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
              <li>
                <a href="topgallery.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-plus"></i>
                            Top Gallery 
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="footergallery.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-plus"></i>
                            Footer Gallery
                        </span>
                    </div>
                </a>
            </li>
                
        </ul>
    </li>
    
    
    <li class="purple">
        <a href="article.php">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">List of Article </span>
        </a>
    </li>
    
    <li class="purple">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Compose Article </span>
        </a>

        <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
              <li>
                <a href="customnewscomposer.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Custom News Composer
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="globalarticle.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Compose Global Multiple Article
                        </span>
                    </div>
                </a>
            </li>
                
        </ul>
    </li>

    <li class="light-blue">
        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
            <img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
            <span class="user-info">
                <small>Welcome,</small>
                <?php echo $_SESSION['SESS_USERNAME']; ?>
            </span>

            <i class="icon-caret-down"></i>
        </a>

        <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li>
                <a href="#">
                    <i class="icon-cog"></i>
                    Settings
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="icon-user"></i>
                    Profile
                </a>
            </li>

            <li class="divider"></li>

            <li>
                <a href="class/logout.php">
                    <i class="icon-off"></i>
                    Logout
                </a>
            </li>
        </ul>
    </li>
</ul><!-- /.ace-nav -->

<?php }elseif($status==3)
{ 
    
    ?>

<ul class="nav ace-nav">
	
    <li class="purple">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Link And File  </span>
        </a>

        <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
              <li>
                <a href="link.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Seo Meta tag /Add /Delete/Edit
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="file.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Upload File in Root Directory
                        </span>
                    </div>
                </a>
            </li>
                
        </ul>
    </li>
    <li class="purple">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">SEO  </span>
        </a>

        <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
              <li>
                <a href="keyword.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Keyword /Add /Delete/Edit
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="description.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Description Add
                        </span>
                    </div>
                </a>
            </li>
                
        </ul>
    </li>
    <li class="light-blue">
        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
            <img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
            <span class="user-info">
                <small>Welcome,</small>
                <?php echo $_SESSION['SESS_USERNAME']; ?>
            </span>

            <i class="icon-caret-down"></i>
        </a>

        <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li>
                <a href="#">
                    <i class="icon-cog"></i>
                    Settings
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="icon-user"></i>
                    Profile
                </a>
            </li>

            <li class="divider"></li>

            <li>
                <a href="class/logout.php">
                    <i class="icon-off"></i>
                    Logout
                </a>
            </li>
        </ul>
    </li>
</ul><!-- /.ace-nav -->
<?php
     
    
}elseif($status==2){ ?>
<ul class="nav ace-nav">
	<li class="green">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="icon-envelope icon-animated-vertical"></i>
            <span class="badge badge-success">
			Online Servey <?php echo getrowstotal("online_servey"); ?>
            </span>
        </a>

        <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
            <li class="dropdown-header">
                <a href="onlineservey.php">
                <i class="icon-envelope-alt"></i>
                List Of Servey
                </a>
            </li>
        </ul>
    </li>

    
    <li class="purple">
        <a href="setbreakingnews.php">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Breaking News </span>
        </a>
    </li>
    
    <li class="purple">
        <a href="topsix.php">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Top Six </span>
        </a>
    </li>
    
    <li class="purple">
        <a  href="#" data-toggle="dropdown" class="dropdown-toggle">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Gallery Data</span>
        </a>
        <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
              <li>
                <a href="topgallery.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-plus"></i>
                            Top Gallery 
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="footergallery.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-plus"></i>
                            Footer Gallery
                        </span>
                    </div>
                </a>
            </li>
                
        </ul>
    </li>
    
    
    <li class="purple">
        <a href="article.php">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">List of Article </span>
        </a>
    </li>
    
    <li class="purple">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Compose Article </span>
        </a>

        <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
              <li>
                <a href="customnewscomposer.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Custom News Composer
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="globalarticle.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Compose Global Multiple Article
                        </span>
                    </div>
                </a>
            </li>
                
        </ul>
    </li>

    <li class="light-blue">
        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
            <img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
            <span class="user-info">
                <small>Welcome,</small>
                <?php echo $_SESSION['SESS_USERNAME']; ?>
            </span>

            <i class="icon-caret-down"></i>
        </a>

        <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li>
                <a href="#">
                    <i class="icon-cog"></i>
                    Settings
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="icon-user"></i>
                    Profile
                </a>
            </li>

            <li class="divider"></li>

            <li>
                <a href="class/logout.php">
                    <i class="icon-off"></i>
                    Logout
                </a>
            </li>
        </ul>
    </li>
</ul><!-- /.ace-nav -->
<?php }elseif($status==1){ ?>
<ul class="nav ace-nav">


 <li class="purple">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="icon-bell-alt icon-animated-bell"></i>
            <span class="badge badge-important">Compose Article </span>
        </a>

        <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
            <li>
                <a href="customnewscomposer.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Custom News Composer
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="globalarticle.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Compose Global Multiple Article
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="setbreakingnews.php">
                    <div class="clearfix">
                        <span class="pull-left">
                            <i class="btn btn-xs no-hover btn-info icon-twitter"></i>
                            Set Breaking News
                        </span>
                    </div>
                </a>
            </li>            
        </ul>
    </li>

    <li class="light-blue">
        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
            <img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
            <span class="user-info">
                <small>Welcome,</small>
                <?php echo $_SESSION['SESS_USERNAME']; ?>
            </span>

            <i class="icon-caret-down"></i>
        </a>

        <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li>
                <a href="#">
                    <i class="icon-cog"></i>
                    Settings
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="icon-user"></i>
                    Profile
                </a>
            </li>

            <li class="divider"></li>

            <li>
                <a href="class/logout.php">
                    <i class="icon-off"></i>
                    Logout
                </a>
            </li>
        </ul>
    </li>
</ul><!-- /.ace-nav -->
<?php } ?>

