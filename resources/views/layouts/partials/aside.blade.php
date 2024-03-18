<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        {{-- <img src="{{ asset('/assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo"> --}}
        <span class="ms-1 font-weight-bold text-white">{{ config('app.name', 'KLL Portal') }}</span>
      </a>
    </div>
  
    <hr class="horizontal light mt-0 mb-2">
  
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.dashboard') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">dashboard</i>
                </div>
            
            <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>

        
        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.users.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">person</i>
                </div>
            
            <span class="nav-link-text ms-1">User Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.enrollments.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">table_view</i>
                </div>
            
            <span class="nav-link-text ms-1">Enrollments</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.curricula.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">library_books</i>
                </div>
            
            <span class="nav-link-text ms-1">Curricula</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.courses.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">library_books</i>
                </div>
            
            <span class="nav-link-text ms-1">Courses</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.subjects.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">library_books</i>
                </div>
            
            <span class="nav-link-text ms-1">Subjects</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.student-resources.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">library_books</i>
                </div>
            
            <span class="nav-link-text ms-1">Student Resources</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.library-resources.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">library_books</i>
                </div>
            
            <span class="nav-link-text ms-1">Library Resources</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.online-learning.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">library_books</i>
                </div>
            
            <span class="nav-link-text ms-1">Online Learning</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.exams.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">article</i>
                </div>
            
            <span class="nav-link-text ms-1">Exams</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.academic-calendar.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">calendar_month</i>
                </div>
            
            <span class="nav-link-text ms-1">Academic Calendar</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.clubs.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">groups</i>
                </div>
            
            <span class="nav-link-text ms-1">Clubs</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.sports.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">sports_basketball</i>
                </div>
            
            <span class="nav-link-text ms-1">Sports</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.events.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">emoji_events</i>
                </div>
            
            <span class="nav-link-text ms-1">Events</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.news.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">newspaper</i>
                </div>
            
            <span class="nav-link-text ms-1">News</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.virtual-tour.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">table_view</i>
                </div>
            
            <span class="nav-link-text ms-1">Virtual Tour</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.about.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">description</i>
                </div>
            
            <span class="nav-link-text ms-1">About</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.admission.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">description</i>
                </div>
            
            <span class="nav-link-text ms-1">Admission</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.student-handbook.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">description</i>
                </div>
            
            <span class="nav-link-text ms-1">Student Handbook</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.banner-slide.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">feed</i>
                </div>
            
            <span class="nav-link-text ms-1">Banner Slide</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.testimonial.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">description</i>
                </div>
            
            <span class="nav-link-text ms-1">Testimonials</span>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.roles.index') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">table_view</i>
                </div>
            
            <span class="nav-link-text ms-1">Roles</span>
            </a>
        </li> --}}
        
            
        {{-- <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('admin.users') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">table_view</i>
                </div>
            
            <span class="nav-link-text ms-1">Tables</span>
            </a>
        </li>
        
            
        <li class="nav-item">
            <a class="nav-link text-white " href="./billing.html">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">receipt_long</i>
                </div>
            
            <span class="nav-link-text ms-1">Billing</span>
            </a>
        </li>
        
            
        <li class="nav-item">
            <a class="nav-link text-white " href="./virtual-reality.html">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">view_in_ar</i>
                </div>
            
            <span class="nav-link-text ms-1">Virtual Reality</span>
            </a>
        </li>
        
            
        <li class="nav-item">
            <a class="nav-link text-white " href="./rtl.html">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                </div>
            
            <span class="nav-link-text ms-1">RTL</span>
            </a>
        </li>
        
            
        <li class="nav-item">
            <a class="nav-link text-white " href="./notifications.html">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">notifications</i>
                </div>
            
            <span class="nav-link-text ms-1">Notifications</span>
            </a>
        </li>
        
            
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
            </li>
            
        <li class="nav-item">
            <a class="nav-link text-white " href="./profile.html">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">person</i>
                </div>
            
            <span class="nav-link-text ms-1">Profile</span>
            </a>
        </li>
        
            
        <li class="nav-item">
            <a class="nav-link text-white " href="./sign-in.html">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">login</i>
                </div>
            
            <span class="nav-link-text ms-1">Sign In</span>
            </a>
        </li>
        
            
        <li class="nav-item">
            <a class="nav-link text-white " href="./sign-up.html">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">assignment</i>
                </div>
            
            <span class="nav-link-text ms-1">Sign Up</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link text-white " href="{{ route('logout') }}">
            
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">login</i>
                </div>
            
            <span class="nav-link-text ms-1">Sign Out</span>
            </a>
        </li>
      </ul>
    </div>
    
    <!-- <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline-primary mt-4 w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree" type="button">Documentation</a>
        <a class="btn bg-gradient-primary w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
      </div>
      
    </div> -->
    
  </aside>