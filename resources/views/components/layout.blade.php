<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>OurApp</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/main.css" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <header class="header-bar mb-3">
      <div class="container d-flex flex-column flex-md-row align-items-center p-3">



        <h4 class="my-0 mr-md-auto font-weight-normal"><a href="/" class="text-white">Candi Vote</a></h4>
        @if(auth()->user())
        <div class="flex-row my-3 my-md-0">

          <a href="/profile/{{auth()->user()->id}}" class="mr-2"><i class="bi bi-person-circle" style="color: white"></i></a>

          @if ((auth()->user()->is_super_admin==true) or (auth()->user()->is_admin == true))
          <a href="/" class="btn btn-sm btn-success mr-2" href="/candidate-info">Add User</a>
          <a href="/" class="btn btn-sm btn-success mr-2" href="/candidate-info">Users</a>
          @endif
          <a href="/" class="btn btn-sm btn-success mr-2 " style="color: black">Profile</a>
          <a href="/store-post-page/{{auth()->user()->id}}" class="btn btn-sm btn-success mr-2 " style="color: black">Add Post</a>
          <a href="/change-password-page" class="btn btn-sm btn-success mr-2 " style="color: black">Change Password</a>
          <form action="/signout" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-sm btn-secondary">Sign Out</button>
          </form>
        </div>
          @else
          <form action="/login" method="GET" class="mb-0 pt-2 pt-md-0">
            @csrf
            <div class="row align-items-center">
                <div class="col-md-auto">
                    <button class="btn btn-primary btn-sm">Already Hav An Account?</button>
                </div>
            </div>
          </form>
        @endif

      </div>
    </header>
    <!-- header ends here -->

    @if (session()->has('success'))
      <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="container container-narrow">
        <div class="alert alert-success text-center">
          {{session('success')}}
        </div>
      </div>
    @endif

    @if (session()->has('alert'))
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="container container-narrow">
        <div class="alert alert-danger text-center">
          {{session('alert')}}
        </div>
      </div>
    @endif


    {{$slot}}

    <!-- footer begins -->
    <footer class="border-top text-center small text-muted py-3">
        <p class="m-0">Copyright &copy; {{date('Y')}} <a href="/" class="text-muted">Candi Vote</a>. All rights reserved.</p>
      </footer>

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      <script>
        $('[data-toggle="tooltip"]').tooltip()
      </script>
    </body>
  </html>
