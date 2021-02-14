@extends('layouts.app', ['activePage' => 'post_tweet'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header card-header-warning">
              <h4 class="card-title">Post a Tweet</h4>
              <p class="card-category">Please, only 140 characters for text and max 1mb size image</p>
              <p class="card-category">Don't forget enable extension=gd in php.ini</p>
            </div>
            <div class="card-body table-responsive">
              
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{$error}}</li>
                          @endforeach
                      </ul>
                  </div>  
              @endif
              @if (session('message'))
                  <script>
                    setTimeout(function() { alert('Twitter stored!'); }, 1000);
                  </script>
              @endif
              <form id="frmContact" action="{{ route('tweet')}}" enctype="multipart/form-data" method="POST">
                @csrf
                
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                    <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                    <div>
                        <span class="btn btn-raised btn-round btn-default btn-file">
                            <span class="fileinput-new">Select image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="image" id="image" />
                        </span>
                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="tweet">Your tweet</label>
                  <input type="text" class="form-control" name="text" maxlength="140">                 
                </div>
                <!-- <input type="hidden" value="{{ Auth::user()->username }}" name="username"/> -->
                <button type="submit" class="btn btn-primary" >Submit</button>

              </form>

              <!-- Modal data-toggle="modal" data-target="#exampleModal"  -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">  
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Twitter stored</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body"> Thank you for your post</div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
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

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush
