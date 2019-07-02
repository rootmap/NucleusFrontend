<?php if($status==4){ ?>
<ul class="nav nav-list">
    <li>
        <a href="index.php">
            <i class="icon-dashboard"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="adminlist.php">
            <i class="icon-group"></i>
            <span class="menu-text"> Admin Access </span>
        </a>
    </li>
        <li>
        <a href="reporterlist.php">
            <i class="icon-folder-close"></i>
            <span class="menu-text"> Reporter Info </span>
        </a>
    </li>
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-folder-close"></i>
            <span class="menu-text"> Page Info </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
          <li>
                <a href="category.php">
                    <i class="icon-double-angle-right"></i>
                    Create a Page Name
                </a>
          </li>
          <li>
                <a href="category.php?action=onspecial">
                    <i class="icon-double-angle-right"></i>
                    On Special Menu
                </a>
          </li>
          <li>
                <a href="category.php?action=offspecial">
                    <i class="icon-double-angle-right"></i>
                    Off Special Menu
                </a>
          </li>
          <li>   
                <a href="globalarticle.php">
                    <i class="icon-double-angle-right"></i>
                   Create a Global Article
                </a>
            </li>
            <li>   
                <a href="customnewscomposer.php">
                    <i class="icon-double-angle-right"></i>
                   Custom News Article Post
                </a>
            </li>
            <li>   
              <a href="lastfivearticle.php">
                    <i class="icon-double-angle-right"></i>
                   List of Global Article
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="menulist.php" class="dropdown-toggle">
            <i class="icon-asterisk"></i>
            <span class="menu-text"> Menu Setting </span>
        </a>
    </li>
    <li>
        <a href="menulist.php" class="dropdown-toggle">
            <i class="icon-asterisk"></i>
            <span class="menu-text"> Breaking News  </span>
            <b class="arrow icon-angle-down"></b>
        </a>
        <ul class="submenu">
            <li>
                <a href="setbreakingnews.php">
                    <i class="icon-double-angle-right"></i>
                    Set Breaking News
                </a>
          </li>
             <li>   
                <a href="bn.php?id=1">
                    <i class="icon-double-angle-right"></i>
                    On Breaking News
                </a>
            </li>
            <li>   
                <a href="bn.php?id=2">
                    <i class="icon-double-angle-right"></i>
                   Off Breaking News
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="onlineservey.php" class="dropdown-toggle">
            <i class="icon-asterisk"></i>
            <span class="menu-text"> Online Servay </span>
        </a>
    </li>
</ul><!-- /.nav-list -->
<?php 
}
elseif($status==3) {
?>
<ul class="nav nav-list">
    <li>
        <a href="index.php">
            <i class="icon-dashboard"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="link.php" class="dropdown-toggle">
            <i class="icon-folder-close"></i>
            <span class="menu-text"> Seo Meta tag </span>
        </a>
    </li>
    <li>
        <a href="file.php" class="dropdown-toggle">
            <i class="icon-folder-close"></i>
            <span class="menu-text"> Upload File in Root </span>
        </a>
    </li>
    <li>
        <a href="keyword.php" class="dropdown-toggle">
            <i class="icon-folder-close"></i>
            <span class="menu-text"> Keyword /Add /Delete/Edit </span>
        </a>
    </li>
    <li>
        <a href="description.php" class="dropdown-toggle">
            <i class="icon-folder-close"></i>
            <span class="menu-text"> Description Add </span>
        </a>
    </li>

</ul><!-- /.nav-list -->
<?php
}
elseif($status==2) {
    ?>
<ul class="nav nav-list">
    <li>
        <a href="index.php">
            <i class="icon-dashboard"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="menulist.php" class="dropdown-toggle">
            <i class="icon-asterisk"></i>
            <span class="menu-text"> Setting News  </span>
            <b class="arrow icon-angle-down"></b>
        </a>
        <ul class="submenu">
          	<li>
                <a href="category.php">
                    <i class="icon-double-angle-right"></i>
                    Create a Page Name
                </a>
          	</li>
            <li>
                <a href="setbreakingnews.php">
                    <i class="icon-double-angle-right"></i>
                    Set Breaking News
                </a>
          </li>
             <li>   
                <a href="bn.php?id=1">
                    <i class="icon-double-angle-right"></i>
                    On Breaking News
                </a>
            </li>
            <li>   
                <a href="bn.php?id=2">
                    <i class="icon-double-angle-right"></i>
                   Off Breaking News
                </a>
            </li>
            <li>
                <a href="category.php?action=onspecial">
                    <i class="icon-double-angle-right"></i>
                    On Special Menu
                </a>
          </li>
          <li>
                <a href="category.php?action=offspecial">
                    <i class="icon-double-angle-right"></i>
                    Off Special Menu
                </a>
          </li>
          <li>
                <a href="special.php">
                    <i class="icon-double-angle-right"></i>
                    Update Special Cover
                </a>
          </li>
        </ul>
    </li>

</ul><!-- /.nav-list -->
<?php
}
elseif($status==1) {
    ?>
<ul class="nav nav-list">
    <li>
        <a href="index.php">
            <i class="icon-dashboard"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-folder-close"></i>
            <span class="menu-text"> Page Info </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="category.php">
                    <i class="icon-double-angle-right"></i>
                    Create a Page Name
                </a>
          </li>
            <li>   
                <a href="globalarticle.php">
                    <i class="icon-double-angle-right"></i>
                   Create a Global Article
                </a>
            </li>
            <li>   
                <a href="customnewscomposer.php">
                    <i class="icon-double-angle-right"></i>
                   Custom News Article Post
                </a>
            </li>
        </ul>
    </li>
   
    <li>
        <a href="onlineservey.php" class="dropdown-toggle">
            <i class="icon-asterisk"></i>
            <span class="menu-text"> Online Servay </span>
        </a>
    </li>
</ul><!-- /.nav-list -->
<?php
}
?>
