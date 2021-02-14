<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">

  <div class="logo">
    <a href="" class="simple-text logo-normal">
      {{ __('Twitter') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      
      <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('profile.edit') }}">
          <i class="material-icons">face</i>
          <span class="sidebar-normal">{{ __('My Profile') }} </span>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'post_tweet' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('postTweet') }}">
          <i class="material-icons">post_add</i>
          <span class="sidebar-normal">{{ __('Post a tweet') }} </span>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'userprofile' ? ' active' : '' }}">
        <a class="nav-link" href="{{ url('profile/'.Auth::user()->username )}}">
          <i class="material-icons">account_circle</i>
          <span class="sidebar-normal">{{ __('User profile') }} </span>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'timeline' ? ' active' : '' }}">
        <a class="nav-link" href="{{ url('timeline' )}}">
          <i class="material-icons">query_builder</i>
          <span class="sidebar-normal">{{ __('Timeline') }} </span>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'userslist' ? ' active' : '' }}">
        <a class="nav-link" href="{{ url('userslist' )}}">
          <i class="material-icons">supervisor_account</i>
          <span class="sidebar-normal">{{ __('Users List') }} </span>
        </a>
      </li>

    </ul>
  </div>
</div>
