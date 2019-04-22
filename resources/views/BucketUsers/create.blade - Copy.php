

 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
@extends('Channels.base')
@section('action-content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new Channel Questions</div>
                <div class="panel-body"> 
                    <form class="form-horizontal" role="form" name = "add_name" id = "add_name"  method="POST" action="{{ url ('ChannelController/store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-4 control-label">Select Channels</label>
                            <div class="col-md-6">
                                <select class="form-control" name="ChannelsIncoming">
                                   <option value="">Select Channels</option> 
                                    @foreach ($ChannelsIncoming as $Channels)
                                        <option value="{{$Channels->ChannelId}}">{{$Channels->ChannelName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       
                         
                         <div class="form-group">
                            <label class="col-md-4 control-label">Add More Questions</label>
                            <div class="col-md-6" id = "dynamic_field">
                            <input type="text" name="name[]" placeholder="Enter Questions" class="form-control name_list" value="{{ old('promoCode') }}" required autofocus>
                        </div>
                        <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                        </div>
                        <div class="form-group">
                         <label class="col-md-4 control-label">Option 1</label>
                            <div class="col-md-6" id = "dynamic_field">
                            <input type="text" name="option[]" class="form-control name_list" placeholder="Enter Option 1"  value="{{ old('promoCode') }}" required autofocus>
                         </div>
                        </div>
                         <div class="form-group">
                         <label class="col-md-4 control-label">Option 2</label>
                            <div class="col-md-6" id = "dynamic_field">
                            <input type="text" name="option[]" placeholder="Enter Option 2" class="form-control name_list"  value="{{ old('promoCode') }}" required autofocus>
                         </div>
                        </div>
                         <div class="form-group">
                         <label class="col-md-4 control-label">Option 3</label>
                            <div class="col-md-6" id = "dynamic_field">
                            <input type="text" name="option[]" placeholder="Enter Option 3" class="form-control name_list"  value="{{ old('promoCode') }}" required autofocus>
                         </div>
                        </div>
                         <div class="form-group">
                         <label class="col-md-4 control-label">Option 4</label>
                            <div class="col-md-6" id = "dynamic_field">
                            <input type="text" name="option[]" placeholder="Enter Option 4" class="form-control name_list"   value="{{ old('promoCode') }}" required autofocus>
                         </div>
                        </div>
                      
                       
                        </div>
                        </div>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                        </div>
                         <div class="alert alert-success print-success-msg" style="display:none">
                         <ul></ul>
                         </div>
                       
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    $(document).ready(function(){      
      var postURL = "<?php echo url('ChannelController/create'); ?>";
      var i=1;  


      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<div id="row'+i+'" class="dynamic-added"><div><input type="text" name="name[]" placeholder="Enter Questions" class="form-control name_list" /></div><div><input type="text" name="option[]" placeholder="Enter Option 1" class="form-control name_list" /></div><div><input type="text" name="option[]" placeholder="Enter Option 2" class="form-control name_list" /></div><div><input type="text" name="option[]" placeholder="Enter Option 3" class="form-control name_list" /></div><div><input type="text" name="option[]" placeholder="Enter Option 4" class="form-control name_list" /></div><div></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">Remove</button></div>');  
      });  


      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  


      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });


      $('#submit').click(function(){            
           $.ajax({  
                url:postURL,  
                method:"POST",  
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)  
                {
                    if(data.error){
                        printErrorMsg(data.error);
                    }else{
                        i=1;
                        $('.dynamic-added').remove();
                        $('#add_name')[0].reset();
                        $(".print-success-msg").find("ul").html('');
                        $(".print-success-msg").css('display','block');
                        $(".print-error-msg").css('display','none');
                        $(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');
                    }
                }  
           });  
      });  


      function printErrorMsg (msg) {
         $(".print-error-msg").find("ul").html('');
         $(".print-error-msg").css('display','block');
         $(".print-success-msg").css('display','none');
         $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
         });
      }
    });  
</script>
