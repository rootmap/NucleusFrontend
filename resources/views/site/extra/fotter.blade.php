<div class=footer>
  <div class="container w-container">
    <div>
      <div class=w-row>
        <div class="w-col w-col-3 w-col-stack wow fadeInDown" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s>
          <div class=footer-column-2>
            
            <div class="top-margin half" style="margin-top: 0px;">
              <p><strong>{{$pageInfo->site_name}}</strong></p>
              <div>
                <p><span>{{$pageInfo->email}}</span></p>
              </div>
              <div>
                <p><span>{{$pageInfo->phone}}<br/></span></p>
              </div>
            </div>

            <a href=# class="footer-logo-block w-inline-block"><img src="{{url('upload/sitesetting/'.$pageInfo->site_logo)}}" width=150 alt=simpleretailpos class="image-117 w-hidden-medium w-hidden-small w-hidden-tiny"/></a>
            
          </div>
        </div>
        <div class="w-col w-col-3 w-col-stack wow fadeInLeft" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s>
          <div class=footer-title></div>
          <div class>
            <a href="{{Request::path() == '/' ? 'javascript:backtoTop()' :url('/')}}" class="footer-block w-inline-block w--current">
              <div class="footer-link normal">Home</div>
            </a>
            <a href="{{Request::path() == '/' ? '#about-us' :url('/').'#about-us'}}" class="footer-block w-inline-block">
              <div class="footer-link normal">ABOUT US</div>
            </a>
            <a href="{{Request::path() == '/' ? '#features' :url('/').'#features'}}" class="footer-block w-inline-block">
              <div class="footer-link normal">Features</div>
            </a>
            <a href="{{Request::path() == '/' ? '#intregtedSolutions' :url('/').'#intregtedSolutions'}}" class="footer-block w-inline-block">
              <div class="footer-link normal">Intragted Solutions</div>
            </a>
            
            
                        
            
            
          </div>
        </div>


        <div class="w-col w-col-3 w-col-stack wow fadeInLeft" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s>
          <div class=footer-title></div>
          <div class>
            <a href="{{url('pricing')}}" class="footer-block w-inline-block">
              <div class="footer-link normal">Our Pricing</div>
            </a>
            <a href= "{{url('business-pos-system')}}"class="footer-block w-inline-block w--current">
              <div class="footer-link normal">Business POS System </div>
            </a>
            <a href="{{url('simple-cash-register')}}" class="footer-block w-inline-block">
              <div class="footer-link normal">Simple Cash Register
              </div>
            </a>
            <a href="{{url('retail-store')}}" class="footer-block w-inline-block">
              <div class="footer-link normal">POS For Retail Store
              </div>
            </a>
          </div>
        </div>



        <div class="w-col w-col-3 w-col-stack wow fadeInLeft" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s>
          <div class=footer-title></div>
          <div class>
            <a href= "{{url('blog')}}"class="footer-block w-inline-block w--current">
              <div class="footer-link normal">Blog </div>
            </a>
            <a href="{{url('question')}}" class="footer-block w-inline-block">
              <div class="footer-link normal">Questions
              </div>
            </a>
            <a href="{{Request::path() == '/' ? '#contactus' :url('/').'#contactus'}}" class="footer-block w-inline-block">
              <div class="footer-link normal">Contact Us</div>
            </a>
            <a href="#" class="footer-logo-block w-inline-block footer-block w-inline-block"><img src="{{url('site/images/nucleuspos.png')}}" width="150" alt="simpleretailpos" class="image-117 w-hidden-medium w-hidden-small w-hidden-tiny"/></a>
          </div>
        </div>

      </div>
    </div>
    <div class="clearfix"></div>
    <div class="top-margin">
      <div>
        <p class="copyright">Copyright © 2019 SimpleRetailPOS.com<br/></p>
      </div>
    </div>
  </div>
</div>