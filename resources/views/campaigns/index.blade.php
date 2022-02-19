@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div style="text-align: right;margin-bottom: 20px">
                <a style="width: 200px" href="{{ route('create-campaign') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Campaigns') }}</div>

                @if(Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if(Session::get('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif
                
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">User</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Status</th>
                                <th scope="col">Total Budget</th>
                                <th scope="col">Daily Budget</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaigns as $campaign)
                            <tr>
                                <th scope="row">{{ $campaign->id }}</th>
                                <td>{{ $campaign->name }}</td>
                                <td>{{ $campaign->users->name }}</td>
                                <td>{{ $campaign->start_date . ' -- ' . $campaign->end_date }}</td>
                                <td>{{ $campaign->status }}</td>
                                <td>{{ $campaign->total_budget }}</td>
                                <td>{{ $campaign->daily_budget }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="showImageModal({{$campaign->images}})"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span></button>
                                    <a class="btn btn-success" href="/campaigns/{{ $campaign->id }}/edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    <a class="btn btn-danger delete-campaign" href="/campaigns/{{ $campaign->id }}/delete" onclick="return confirm(' you want to delete?');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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


<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

@endsection



@section('script')

<script type="text/javascript">
    $(function() {
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
    });

    function showImageModal(images) {
        $('.carousel-inner').html('');
        var inner_html = '';
        images.forEach(function(images, index) {
            if(index === 0){
                inner_html += '<div class="item active"><img src="/images/' + images.image + '" alt="Image"></div>';
            }else{
                inner_html += '<div class="item"><img src="/images/' + images.image + '" alt="Image"></div>';
            }
            
        })
        $('.carousel-inner').html(inner_html);
    }
</script>

@endsection
