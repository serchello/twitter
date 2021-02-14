@extends('layouts.app', ['activePage' => 'api_statistics', 'title' => 'api_statistics'])

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
                        <th>Path</th>
                        <th>Total visits</th>             
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($statistics as $statistic)
                        <tr>
                          <td>{{ $statistic->username }}</td>
                          <td>{{ $statistic->url }}</td>
                          <td>{{ $statistic->total_visits }}</td> 
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