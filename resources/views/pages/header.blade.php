<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="{{ url('/index') }}"><img src="{{ url('public/images/logo.png') }}" class="logo1"></a>

  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">

    <span class="navbar-toggler-icon"></span>

  </button>

  <div class="top-details">

    <span class="dates">Date : <?php echo date("d-m-Y"); ?></span> 

  </div>

  <ul class="navbar-nav px-3">

    <li class="nav-item text-nowrap">

      <a class="nav-link" href="/logout">Sign out</a>

    </li>

  </ul>

</nav>