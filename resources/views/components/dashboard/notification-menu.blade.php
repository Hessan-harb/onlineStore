<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i data-feather="bell"></i>
			<div class="indicator">
				<div class="circle"></div>
			</div>
							</a>
							<div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
								<div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
									<p>{{$newcount}} New Notifications</p>
									<a href="javascript:;" class="text-muted">Clear all</a>
								</div>
               				 <div class="p-1">
                
                 
                                @foreach($notifications as $notification) 
								<a href="{{$notification->data['url']}}" class="dropdown-item d-flex align-items-center py-2">
									<div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
										<i class="icon-sm text-white" data-feather="{{$notification->data['icon']}}"></i>
									</div>
									<div class="flex-grow-1 me-2">
											<p>{{$notification->data['icon']}}</p>
											<p class="tx-12 text-muted">{{$notification->created_at->diffForHummans()}}</p>
										</div>	
								</a>
                                @endforeach
									</div>
								<div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
									<a href="javascript:;">View all</a>
								</div>
							</div>
						</li>