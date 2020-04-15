<header class="section page-header">
	<div class="rd-navbar-wrap novi-background">
	  <nav class="rd-navbar rd-navbar-top-panel-lightnav rd-navbar rd-navbar-top-panel-light" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-fullwidth" data-xl-device-layout="rd-navbar-fullwidth" data-xxl-layout="rd-navbar-fullwidth" data-xxl-device-layout="rd-navbar-fullwidth" data-lg-stick-up-offset="90px" data-xl-stick-up-offset="90px" data-xxl-stick-up-offset="90px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true" data-stick-up-clone="true">
	    <div class="rd-navbar-inner">
	      <div class="rd-navbar-nav-wrap">
	        <ul class="rd-navbar-nav">
	          <li><a href="{{url('pricing')}}">Pricing</a></li>
	          <li><a href="{{url('hardware')}}">Hardware</a></li>
	          <li><a href="{{url('videos')}}">Videos</a></li>
	          
	          <li>
	              <a href="{{url('question')}}">Questions</a>
	              <ul class="rd-navbar-dropdown">
	                  <li><a href="{{url('blog')}}">BLOG</a></li>
	                  <li><a href="{{url('business-pos-system')}}">BUSINESS POS SYSTEM</a></li>
	                  <li><a href="{{url('simple-cash-register')}}">SIMPLE CASH REGISTER</a></li>
	                  <li><a href="{{url('retail-store')}}">POS FOR RETAIL STORE</a></li>
	              </ul>
			  </li>
			  <li><a href="{{Request::path() == '/' ? '#contactus' :url('/').'#contactus'}}">Contact us</a></li>
	        </ul>
	      </div>
	      <div class="rd-navbar-panel">
	        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
	        <div class="rd-navbar-brand">
	        	<a class="brand-name" href="{{Request::path() == '/' ? 'javascript:backtoTop()' :url('/')}}">
	          		<img src="{{url('upload/sitesetting/'.$pageInfo->site_logo)}}" alt="{{$pageInfo->site_name}}" />
	      		</a>
	      	</div>
	        </div>
	        <div class="rd-navbar-top-panel">
	          <div class="rd-navbar-top-panel-toggle" data-rd-navbar-toggle=".rd-navbar-top-panel"><span></span></div>
	          <div class="rd-navbar-top-panel-content">
	            <a class="btn btn-sm btn-primary btn-effect-ujarak" href="{{Request::path() == '/' ? '#signup' :url('/').'#signup'}}">SIGNUP</a>
	            <a class="btn btn-sm btn-primary btn-effect-ujarak" target="_blank" href="http://app.simpleretailpos.com">LOGIN</a>
	          </div>
	        </div>
	      </div>
	    </nav>
	</div>
</header>