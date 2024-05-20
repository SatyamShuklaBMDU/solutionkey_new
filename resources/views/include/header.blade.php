<div class="header_iner d-flex justify-content-between align-items-center position-relative"style="padding: 0;margin: 0;height:50px !important;">
    <div class="sidebar_icon d-lg-none">
        <i class="ti-menu"></i>
    </div>
    <div class="serach_field-area">
        <div class="search_inner">

        </div>
    </div>
    <div class="header_right d-flex justify-content-between align-items-center">
        <div class="header_notification_warp d-flex align-items-center">

        </div>
        <div class="profile_info">
            <img src="{{ asset('img/client_img.png') }}" alt="#">
            <div class="profile_info_iner">
                {{-- <p>Welcome Admin!</p>
                <h5>Solutions key</h5> --}}
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();"
                            style="padding-left:6rem !important;text-decoration:none;color:aliceblue;font-size:16px">
                            {{ __('Logout') }}
                        </x-dropdown-link>
                        <i class="ti-shift-left"></i>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<hr style="
padding: 0;
margin: 0;color:black;margin-bottom:1rem;">
