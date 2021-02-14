@extends('layouts.app', ['activePage' => 'userprofile'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">       
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">User Profile</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                        <tr>
                            <th>Username</th>
                            <th>email</th>
                            <th>Total Tweets</th>
                            <th>Total Followers</th>
                            <th>Total Following</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                          @foreach($users as $user)
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->total_tweets }}</td> 
                            <td>{{ $user->total_followers }}</td>
                            <td>{{ $user->total_followings }}</td>
                          @endforeach
                        </tr>
                    </tbody>
                  </table> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     
        <div class="col-md-12">  
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">User Tweets</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                      <tr>
                          <th>#</th>
                          <th>Image</th>
                          <th>Tweet text</th>
                          <th>updated_at</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($tweets as $key=>$tweet)
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td><img src="{{ asset('images/'.$tweet->username.'/'.$tweet->image) }}" alt="" title=""></a></td>
                        <td>{{ $tweet->text }}</td>
                        <td>{{ $tweet->updated_at }}</td>
                      </tr>
                    @endforeach 
                  </tbody>
                </table>
                <p> {{ $tweets->links() }}</p> 
                </div>
              </div>
            </div>
          </div>
        </div>
    

    </div>
  </div>

@endsection