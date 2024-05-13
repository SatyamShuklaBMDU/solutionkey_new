<div class="header_iner d-flex justify-content-between align-items-center border-bottom m-3"  style="margin:0;">
    <div class="sidebar_icon d-lg-none">
        <i class="ti-menu"></i>
    </div>
    <div class="serach_field-area">
        <div class="search_inner">
        
        </div>
    </div>
    <div class="header_right d-flex justify-content-between align-items-center m-1">
        <div class="header_notification_warp d-flex align-items-center">
         
        </div>
        <div class="profile_info">
            <img src="{{ asset('img/client_img.png') }}" alt="client">
            <div class="profile_info_iner">
                <p>Welcome Admin!</p>
                <h5>Solutions key</h5>
                <div class="profile_info_details text-end">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();" style="padding-left:9rem !important;">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                        <i class="ti-shift-left"></i>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
