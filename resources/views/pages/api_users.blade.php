@extends('layouts.app', ['activePage' => 'api_users', 'title' => 'api_users'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">       
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">list with all users</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                  
                  <table class="table">
                    <thead class=" text-primary">
                      <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Total followers</th>
                        <th>Total following</th>
                        <th>Total tweets</th>
                        <th>User profile</th>
                        <th>User Avatar</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($userslists as $userslist)
                        <tr>
                          <td>{{ $userslist->username }}</td>
                          <td>{{ $userslist->email }}</td>
                          <td>{{ $userslist->total_followers }}</td> 
                            <td>{{ $userslist->total_followings }}</td>
                          <td>{{ $userslist->total_user_tweets }}</td>
                          <td><a href="{{ url('profile/'.$userslist->username ) }}">{{ $userslist->username }}</a></td>
                          <td>
                            @if($userslist->avatar)
                                <div class="thumbnail img-raised">
                                    <img src="{{ asset('images/'.$userslist->username.'/avatar.jpg') }}" alt="..." style="max-height:80px; max-width: 80px;">
                                </div>
                            @endif  
                          </td>
                        </tr>
                        @endforeach  
                         
                    </tbody>
                  </table> 
                 
                </div>
              </div>
            </div>
          </div>
        </div>
    
      </div>
      </div>
    </div>
  </div>
@endsection