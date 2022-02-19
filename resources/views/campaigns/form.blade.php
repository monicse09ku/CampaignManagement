@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Create Campaign') }}</div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{ !empty($campaign) ? route('update-campaign') : route('save-campaign') }}" enctype="multipart/form-data"  method="post" autocomplete="off">
                     <fieldset>
                        @csrf

                        <!-- Text input-->
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="control-label text-lg-left" for="name">Name</label>  
                                <div class="">
                                    <input id="name" name="name" type="text" placeholder="Enter Name" class="form-control btn-square input-md" value="{{ old('name', $campaign->name ?? '') }}">
                                    <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="control-label text-lg-left" for="user_id">Select User</label>
                                <div>
                                    <select id="user_id" name="user_id" class="form-control btn-square">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $campaign->user_id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('user_id'){{$message}}@enderror</span>
                                </div>
                           </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="control-label text-lg-left" for="start_date">Start Date</label>  
                                <div class='input-group date' id='datetimepicker'>
                                    <input name="start_date" value="{{ old('start_date') }}" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <span class="text-danger">@error('start_date'){{$message}}@enderror</span>
                           </div>
                           <div class="form-group col-lg-6">
                                <label class="control-label text-lg-left" for="end_date">End Date</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input name="end_date" value="{{ old('end_date') }}" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <span class="text-danger">@error('end_date'){{$message}}@enderror</span>
                           </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label class="control-label text-lg-left" for="total_budget">Total Budget</label>  
                                <div>
                                    <input id="total_budget" name="total_budget" type="text" placeholder="Enter Total Budget" class="form-control btn-square input-md" value="{{ old('total_budget', $campaign->total_budget ?? '') }}">
                                    <span class="text-danger">@error('total_budget'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="control-label text-lg-left" for="daily_budget">Daily Budget</label>  
                                <div>
                                    <input id="daily_budget" name="daily_budget" type="text" placeholder="Enter Daily Budget" class="form-control btn-square input-md" value="{{ old('daily_budget', $campaign->daily_budget ?? '') }}">
                                    <span class="text-danger">@error('daily_budget'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="col-lg-12 control-label text-lg-left" for="status">Select Status</label>
                                <div>
                                    <select id="status" name="status" class="form-control btn-square">
                                        <option value="active" {{ old('status', $campaign->status ?? '') == $user->id ? 'selected' : '' }}>Active</option>
                                        <option value="pendind" {{ old('status', $campaign->status ?? '') == $user->id ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>
                           </div>
                        </div>

                        <input id="deleted_images" type="hidden" name="deleted_images" value="">
                        @if(!empty($campaign))
                            <input type="hidden" name="id" value="{{ $campaign->id }}">
                        @endif
                        @if(!empty($campaign->images))
                            <div class="row">
                                @foreach($campaign->images as $image)
                                    <div class="col-lg-3 delete-image-div">
                                        <img class="img img-responsive" style="padding: 5px 10px" src="{{ '/images/' . $image->image}}">
                                        <a style="position: absolute;top: 0;right: 0" href="javascript:void(0);" class="btn btn-danger delete-image" data1="{{ $image->id }}">X</a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-lg-12 control-label text-lg-left" for="submit">Images</label>
                            <div class="col-lg-12">
                                <input type="file" name="images[]" multiple>
                                <span class="text-danger">@error('images'){{$message}}@enderror</span>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group row">
                            <label class="col-lg-12 control-label text-lg-left" for="submit">Submit</label>
                            <div class="col-lg-12">
                                <button id="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                        </fieldset>
                     </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    $(function() {
        $('#datetimepicker').datetimepicker({
            minDate: moment()
        });
        $('#datetimepicker1').datetimepicker({
            minDate: moment()
        });

        @if(!empty($campaign))
            $("#datetimepicker").datetimepicker().children('input').val("<?php echo $campaign->start_date; ?>");
            $("#datetimepicker1").datetimepicker().children('input').val("<?php echo $campaign->end_date; ?>");
        @endif

        $('.delete-image').click(function(){
            var image_id = $(this).attr('data1');
            var deleted_images = $('#deleted_images').val();

            if(deleted_images.length > 0){
                $('#deleted_images').val(deleted_images + ',' + image_id)
            }else{
                $('#deleted_images').val(image_id)
            }

            $(this).parents('div.delete-image-div').fadeOut();
        });

    });

    // function deleteImage(image_id) {
    //     console.log(image_id)
    //     console.log($(this).parent().attr('id'))
    // }
</script>

@endsection