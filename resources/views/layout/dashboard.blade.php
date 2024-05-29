@extends('include.master')
@section('style-area')
    <style>
        .main_content {
            padding-left: 283px;
            padding-bottom: 0% !important;
            padding-right: 12px;
        }
    </style>
@endsection
@section('content-area')
    <section class="main_content dashboard_part">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="single_element">
                    <div class="quick_activity">
                        <div class="row">
                            <div class="col-lg-12">
                                @if (Session::has('login_message'))
                                    <div id="loginMessage" class="alert alert-success">
                                        {{ Session::get('login_message') }}
                                    </div>
                                @endif
                                <div class="quick_activity_wrap mt-2">
                                  
                                     <!--end col-->
                                    
                                         <div class="single_quick_activity">
                                        <h4>User
                                            Management</h4>
                                        <h3> <span class="counter">5,79,000</span>
                                        </h3>
                                        <p>Saved 25%</p>
                                    </div>
                                  
                                    <!--end col-->
                                   
                                            <div class="single_quick_activity">
                                        <h4>Service
                                            Management</h4>
                                        <h3> <span class="counter">79,000</span>
                                        </h3>
                                        <p>Saved 25%</p>
                                    </div>
                                       
                                    <!--end col--> 
                                    
                                             <div class="single_quick_activity">
                                        <h4>Professional
                                            Management</h4>
                                        <h3> <span class="counter">92,000</span>
                                        </h3>
                                        <p>Saved 25%</p>
                                    </div>
                                        
                                    <!--end col-->
                                 
                                             <div class="single_quick_activity">
                                        <h4>Customer
                                            Management</h4>
                                        <h3> <span class="counter">1,79,000</span>
                                        </h3>
                                        <p>Saved 65%</p>
                                    
                                        </div> 
                                    <!--end col-->
                                    
                                            <div class="single_quick_activity">
                                        <h4>Booking
                                            Scheduling</h4>
                                        <h3> <span class="counter">1,79,000</span>
                                        </h3>
                                        <p>Saved 65%</p>
                                   
                                            </div>
                                             <!--end col-->
                                      
                                            <div class="single_quick_activity">
                                        <h4>Booking
                                            Scheduling</h4>
                                        <h3> <span class="counter">1,79,000</span>
                                        </h3>
                                        <p>Saved 65%</p>
                                   
                                            </div>
                                                 <!--end col-->
                                     
                                            <div class="single_quick_activity">
                                        <h4>Payment &
                                            Invoicing</h4>
                                        <h3> <span class="counter">1,79,000</span>
                                        </h3>
                                        <p>Saved 65%</p>
                                    
                                            </div>
                                                    <!--end col-->
                                      
                                            <div class="single_quick_activity">
                                        <h4>Feedback &
                                            Reviews</h4>
                                        <h3> <span class="counter">1,79,000</span>
                                        </h3>
                                        <p>Saved 65%</p>
                             
                                            </div>
                                                    <!--end col-->
                                      
                                               <div class="single_quick_activity">
                                        <h4>Analytics &
                                            Reporting</h4>
                                        <h3> <span class="counter">1,79,000</span>
                                        </h3>
                                        <p>Saved 65%</p>
                                
                                            </div>
                                    </div>
                                   <!--end row-->
                                 
                                    </div>
                                   
                                  
                                    
                                    
                                 
                              
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script-area')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loginMessage = document.getElementById('loginMessage');
            if (loginMessage) {
                setTimeout(function() {
                    loginMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection
