<aside id="sidebar-left" class="sidebar-circle">
        <style type="text/css">
            .avatarside img {
                width: 100%;
                max-width: 100%;
                height: auto;
                border: 0;
                border-radius: 1000px;
            }

            .sidebar-content img {
                width: 49px !important;
                height: 49px !important;
                margin-right: 3px;
                padding: 5px;
            }
        </style>
        <!-- Start left navigation - profile shortcut -->
        <div id="tour-8" class="sidebar-content" style="padding-top: 20px;">
            <div class="media">
                <a class="pull-left avatarside" href="http://localhost/nucleusv3/">
                    <img src="{{asset('admin/images/logo/icons.png')}}" alt="admin">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"> Simple Retail POS</h4>
                    <small>Total POS &amp; Sales Solutions</small>
                </div>
            </div>
        </div><!-- /.sidebar-content -->
        <!--/ End left navigation -  profile shortcut -->

        <!-- Start left navigation - menu -->
        <ul id="tour-9" class="sidebar-menu">
            <li class="sidebar-category">
                <span>System Quick Links</span>
                <span class="pull-right"><i class="fa fa-link"></i></span>
            </li>
            <!-- Start navigation - dashboard -->
            <li class="">
                <a href="{{url('admin-site')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::path() == 'online/order' ? 'active' : '' }} ">
                <a href="{{url('online/order')}}">
                    <span class="icon"><i class="fa fa-shopping-cart"></i></span>
                    <span class="text">Online Signup</span>
                </a>
            </li>
            <li class="{{ Request::path() == 'admin-site/setting' ? 'active' : '' }} ">
                <a href="{{url('admin-site/setting')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">Site Setting</span>
                </a>
            </li>
            <li class="{{ Request::path() == 'admin-site/slider' ? 'active' : '' }} ">
                <a href="{{url('admin-site/slider')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">Slider</span>
                </a>
            </li>
            <li class="{{ Request::path() == 'admin-site/about' ? 'active' : '' }} ">
                <a href="{{url('admin-site/about')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">About Us</span>
                </a>
            </li>
            <li class="{{ Request::path() == 'admin-site/features' ? 'active' : '' }} ">
                <a href="{{url('admin-site/features')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">Features</span>
                </a>
            </li>
            <li class="{{ Request::path() == 'admin-site/dummy-proof' ? 'active' : '' }} ">
                <a href="{{url('admin-site/dummy-proof')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">Dummy Proof</span>
                </a>
            </li>
            <li class="{{ Request::path() == 'admin-site/price' ? 'active' : '' }} ">
                <a href="{{url('admin-site/price')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">Price</span>
                </a>
            </li>
            
            <!-- Start navigation - frontend themes -->
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <span class="text">Business Reports</span>
                    <span class="arrow"></span>
                </a>
                <ul>
                    <li class="{{ Request::path() == 'admin-site/business-reports' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('admin-site/business-reports')}}" class="menu-item">Add Business Reports</a></li>
                    <li class="{{ Request::path() == 'admin-site/business-reports-features' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('admin-site/business-reports-features')}}" class="menu-item">Business Reports Features</a></li>

                </ul>
            </li>
            <li class="{{ Request::path() == 'admin-site/retail' ? 'active' : '' }} ">
                <a href="{{url('admin-site/retail')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">Retail</span>
                </a>
            </li>
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <span class="text">Plug And Play</span>
                    <span class="arrow"></span>
                </a>
                <ul>
                    <li class="{{ Request::path() == 'admin-site/plug-and-play' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('admin-site/plug-and-play')}}" class="menu-item">Add Plug And Play</a></li>
                    <li class="{{ Request::path() == 'admin-site/plug-and-play-image' ? 'active' : '' }}  border-bottom-purple"><a href="{{url('admin-site/plug-and-play-image')}}" class="menu-item">Plug And Play Image</a></li>

                </ul>
            </li>
            
            <li class="{{ Request::path() == 'admin-site/footer-menu' ? 'active' : '' }} ">
                <a href="{{url('admin-site/footer-menu')}}">
                    <span class="icon"><i class="fa fa-dashboard"></i></span>
                    <span class="text">Footer Seo Link</span>
                </a>
            </li>
          


        
            <!--/ End documentation - api documentation -->

        </ul><!-- /.sidebar-menu -->
        <!--/ End left navigation - menu -->

        <div id="tour-10" class="sidebar-footer hidden-xs hidden-sm hidden-md">
        </div>
    </aside><!-- /#sidebar-left -->


 @section('js')
 <script type="text/javascript">
     document.getElementById("copyButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copyTarget"));
});

function copyToClipboard(elem) {
      // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
          succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
 </script>
 @endsection