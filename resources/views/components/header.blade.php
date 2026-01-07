   <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
   <div class="navbar border-bottom border-body justify-content-start gap-4 ms-4 mb-4">
       @if (Auth::check() && $user)
           <ul class="nav justify-content-end mb-2">

               <li class="nav-item">
                   <a class="nav-link disabled" href="#">Hello,{{ $user }}</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="{{ route('myprofile') }}">My Profile</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="{{ route('posts.create') }}">Create Post</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="{{ route('category.index') }}">Categories</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="{{ route('blogs.index') }}">Blogs</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link text-white bg-dark" href="{{ route('logout') }}">LogOut</a>
               </li>
           </ul>
       @else
           <nav class="navbar border-bottom border-body justify-content-start gap-4 ms-4">
               <a class="navbar-brand" href="#">
                   <img src="{{ asset('image.png') }}" alt="Logo" height="60">
               </a>
               <a class="nav-link active color-white" aria-current="page" href="{{ route('blogs.index') }}">Home</a>
               <a class="nav-link" href="{{ route('login') }}">Login</a>
               <a class="nav-link" href="{{ route('register') }}">Register</a>
               <a class="nav-link" href="{{ route('posts.index') }}">Manage Posts</a>

               <form class="d-flex" role="search" action="{{ route('blogs.index') }}" method="GET">
                   <input class="form-control" type="text" name="search" placeholder="Search" id="search-box"
                       value="{{ request('search') }}" aria-label="Search" />
               </form>
           </nav>

           <div class="container" id= "result-box">
           </div>

           <script>
               $(document).ready(function() {
                   const searchbox = document.getElementById("search-box");
                   const resultbox = document.getElementById("result-box");

                   searchbox.onkeyup = function() {
                       getSuggestions(searchbox.value);
                   }

                   const getSuggestions = debounce(fetch, 500)

                   function debounce(fn, delay) {
                       let timeout

                       return (...args) => {
                           clearTimeout(timeout)
                           timeout = setTimeout(() => {
                               fn(...args)
                           }, delay);
                       }
                   }

                   function fetch(input) {
                       if (input.trim() !== '') {
                           resultbox.style.display = "block";

                           $.ajax({
                               url: "{{ route('blogs.suggestions') }}",
                               method: 'GET',
                               data: {
                                   'search': input
                               },
                               dataType: 'html',
                               success: function(res) {
                                   $("#result-box").html(res);
                               },
                               error: function(error) {
                                   alert('error fetching suggestions', error);
                               }
                           });
                       } else {
                           resultbox.style.display = "none";
                       }
                   }

               });
           </script>
       @endif
   </div>
