@extends('layouts.app', ['activePage' => 'userslist'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">       
         
            <div class="card">  
              <div class="card-header card-header-primary">
                <h4 class="card-title">list of all registered users excluding the current logged in user.</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <tr>
                        <th>Username</th>
                        <th>Total followers</th>
                        <th>Total following</th>
                        <th>Total tweets</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($userslists as $userslist)
                        <tr>
                          <td><a href="{{ url('profile/'.$userslist->username ) }}">{{ $userslist->username }}</a></td>
                          <td>{{ $userslist->total_followers }}</td>
                          <td>{{ $userslist->total_followings }}</td> 
                          <td>{{ $userslist->total_user_tweets }}</td> 
                          <td class="td-actions text-right">
                          <form id="frmContact" action="{{ route('followUnfollow')}}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $userslist->id}}" name="id_person"/>
                            <!-- <input type="hidden" value="{{ Auth::user()->username }}" name="username"/> -->
                            <input type="hidden" value="{{ $userslist->S}}" name="follow_unfollow"/>
                            <input type="submit" class="{{ $userslist->S  ? 'btn btn-danger' : 'btn btn-info' }}" value="{{ $userslist->S  ? 'Unfollow' : 'Follow' }}" name="submit" id="submit">
                          </form>
                          </td> 
                        </tr>
                        @endforeach
                    </tbody>
                  </table> 
                  <p> {{ $userslists->links() }}</p> 
                </div>
              </div>
            </div>
          </div>
        </div>
 
      </div>
    </div>
  </div>
@endsection