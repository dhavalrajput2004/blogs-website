   <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
   <div class="navbar border-bottom border-body justify-content-start gap-4 ms-4 mb-4">

       <nav class="navbar border-bottom border-body justify-content-start gap-4 ms-4">
           <a class="navbar-brand" href="#">
               <img src="{{ asset('image.png') }}" alt="Logo" height="60">
           </a>
           @auth
               <a class="nav-link" href="{{ route('posts.index') }}">My Posts</a>
               <a class="nav-link" href="{{ route('blogs.index') }}">All Posts</a>
               <a class="nav-link" href="{{ route('posts.create') }}">Create Post</a>
               <a class="nav-link" href="{{ route('category.index') }}">Categories</a>
               <a class="nav-link link-dark" href="{{ route('logout') }}">LogOut</a>
           @else
               <a class="nav-link" href="{{ route('login') }}">Login</a>
               <a class="nav-link" href="{{ route('register') }}">Register</a>
           @endauth

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
   </div>
