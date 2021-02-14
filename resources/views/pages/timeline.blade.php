@extends('layouts.app', ['activePage' => 'timeline'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">       
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">list of all tweets from users who follow (followers)</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <tr>
                          <th>Username</th>
                          <th>tweet</th>
                          <th>Date tweet</th>
                      </tr>
                    </thead>
                    <tbody>
                          @foreach($followers as $follower)
                          <tr>
                            <td><a href="{{ url('profile/'.$follower->username ) }}">{{ $follower->username }}</a></td>
                            <td>{{ $follower->text }}</td>
                            <td>{{ $follower->created_at }}</td> 
                          </tr>
                          @endforeach
                         
                    </tbody>
                  </table> 
                  <p> {{ $followers->links() }}</p> 
                </div>
              </div>
            </div>
          </div>
        </div>
      
      
        <div class="row">
          <div class="col-md-12">  
  
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">list of all tweets from users who follow (followings)</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                      <thead class=" text-primary">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>tweet</th>
                            <th>Date tweet</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($followings as  $key=>$following)
                        <tr>
                          <td>{{ ++$key }}</td>
                          <td><a href="{{ url('profile/'.$following->username ) }}">{{ $following->username }}</a></td>
                          <td>{{ $following->text }}</td>
                          <td>{{ $following->created_at }}</td> 
                        </tr>
                        @endforeach
                    </tbody>
                  </table> 
                 <p> {{ $followings->links() }}</p>
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