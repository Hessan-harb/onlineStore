	
   
    <!-- partial:partials/_sidebar.html -->
	<nav class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
          Hussein<span>UI</span>
        </a>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
            @foreach($items as $item)
          <li class="nav-item">
            <a href="{{url($item['route'])}}" class="nav-link">
              <i class="link-icon" data-feather="{{$item['icon']}}"></i>
              <span class="link-title">{{$item['title']}}</span>
            </a>
          </li>
          @endforeach

        </ul>
      </div>
    </nav>
    
		<!-- partial -->

