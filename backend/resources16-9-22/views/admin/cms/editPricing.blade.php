@extends('layouts.admin-template')
@php
$i=1;
@endphp
@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid container-cms">
         <div class="row mb-2">
            <div class="col-sm-12">
               <h1>Pricing Page Content</h1>
            </div>
            
         </div>
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid container-cms">
        @if(session()->has('success'))
         <div class="alert alert-success email-template-page-suc" style="text-align: left;">
            {{ session()->get('success') }}
         </div>
         <script type="text/javascript">setTimeout(function(){ $('.email-template-page-suc').fadeOut(); }, 3000);</script>
         @elseif(session()->has('failure'))
         <div class="alert alert-danger email-template-page-suc" style="text-align: left;">
            {{ session()->get('failure') }}
         </div>
         <script type="text/javascript">setTimeout(function(){ $('.email-template-page-suc').fadeOut(); }, 3000);</script>
         @endif
         <div class="row">
            <!-- left column -->
            <div class="col-md-12">
               <!-- jquery validation -->
               
                  <!-- /.card-header -->
                  <!-- form start -->
                  @if(isset($homepage))
                  <form role="form" method="post" action="{{ route('update-pricing',['id' => base64_encode($homepage['id'])]) }}" id="homepage" name="homepage" enctype="multipart/form-data">
                  @endif
                  <div class="card card-primary">
                    <div class="card-header">
                       <h3 class="card-title">General Info</h3>
                    </div>
                     <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                     <div class="card-body">
                        <div class="form-group">
                           <label>Title</label>
                           <input type="text" value="{{ isset($homepage) ? $homepage['title'] : '' }}" name="general_info[title]" class="form-control" id="title" placeholder="Please Enter Title">
                        </div>
                        <div class="form-group">
                           <label>Meta Title</label>
                           <input type="text" value="{{ isset($homepage) ? $homepage['meta_title'] : '' }}" name="general_info[meta_title]" class="form-control" id="meta_title" placeholder="Please Enter Meta Title">
                        </div>
                        <div class="form-group">
                           <label>Meta Tag</label>
                           <input type="text" value="{{ isset($homepage) ? $homepage['meta_tag'] : '' }}" name="general_info[meta_tag]" class="form-control" id="meta_tag" placeholder="Please Enter Meta Tag">
                        </div>
                        <div class="form-group">
                           <label>Meta Description</label>
                           <input type="text" value="{{ isset($homepage) ? $homepage['title'] : '' }}" name="general_info[meta_description]" class="form-control" id="meta_description" placeholder="Please Enter Meta Description">
                        </div><!-- 
                        <div class="form-group">
                           <label>Content</label>
                           <textarea rows="4" cols="50"  name="general_info[content]" class="form-control calucaltion" id="content" placeholder="Please Enter Message">{{ isset($homepage) ? $homepage['content'] : '' }}</textarea>
                        </div> -->
                     </div>
                     <!-- /.card-body --> 
                     
                  </div>
                  <div class="card card-primary">
                    <div class="card-header">
                       <h3 class="card-title">About Content</h3>
                    </div>                     
                     <div class="card-body">
                      @php 
                      $cmsmeta = $pricing_content['cmsmeta']; 

                        foreach($cmsmeta as $aboutcontent):
                        $aboutconjson = json_decode($aboutcontent->meta_value, true); 
                        if(!empty ($aboutconjson)):
                          foreach($aboutconjson as $key => $viewDAta):
                      @endphp
                      <div class="form-group row">
                                <div class="col-lg-6 my-error">
                                  <label>Heading:</label>
                                  <div class="input-group">
                                                              
                                    <input type="text" name="about_heading"  value="{{isset($viewDAta['about_heading'])? $viewDAta['about_heading'] : '' }}" id="about_heading" class="form-control " placeholder="" accept="image/*" />
                                </div>
                                </div>
                                <div class="col-lg-6 my-error">
                                  <label>Banner Right</label>
                                  <div class="input-group">
                                   <div class="custom-file">                                    
                                    <input type="file" name="about_image_first"  value="" id="about_image_first" class="form-control about_image_first custom-file-input" placeholder="" accept="image/*" />
                                    <input type="hidden" name="old_about_image_first" value="{{isset($viewDAta['about_image_first'])? $viewDAta['about_image_first'] : '' }}"/>
                                     <label class="custom-file-label" for="banner_image">{{isset($viewDAta['about_image_first'])? $viewDAta['about_image_first'] : '' }}</label>
                                </div>
                                </div>
                                </div>
                                
                            </div>                            
                            <div class="form-group row">
                                <div class="col-lg-12 my-error">
                                  <label>About Content:</label>
                                  <textarea name="about_us_content" id="about_us_content" class="about_content_class">{{isset($viewDAta['about_us_content'])? $viewDAta['about_us_content'] : '' }}</textarea>
                                </div> 
                                
                            </div>
                            @php
                          endforeach;
                          endif;
                          endforeach;
                        @endphp
                    </div>
                  </div>

                 <!-- /.card-body --> 
                     <div class="card-footer">
                        <button type="submit" id="update-home-button" class="btn btn-success">Submit</button>
                     </div>
                  </form>
               <!-- /.card -->
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
@endsection
@section('third_party_scripts')
<script type="text/javascript">
  $(document).ready(function(){ 
    CKEDITOR.replace('about_us_content');
    CKEDITOR.editorConfig = function( config ) {
    
    };
    CKEDITOR.config.allowedContent = true;
      $('#aboutpage').validate({
         ignore: [],
              debug: false,
         submitHandler: function(form) {
           // do other things for a valid form
           form.submit();
         },
         rules: {
           title: {
             required: true,
           },
           meta_tag: {
             required: true,
           },
           content: {
             required: true,
           },
           meta_title : {
            required : true,
           }, 
           meta_description : {
            required : true,
           },
           about_us_content:{
             required: function() 
            {
             CKEDITOR.instances.content.updateElement();
            },
            minlength:1
           },
         },
         messages: {
           title: {
             required: "Please enter title.",
           },
           meta_tag: {
             required: "Please enter meta tag.",
           },
           content:{
            required:"Please enter content",
           },
           meta_title: {
            required:"Please enter meta title."
           },
           meta_description: {
            required:"Please enter meta description."
           }
         },
         errorElement: 'span',
         errorPlacement: function (error, element) {
           error.addClass('invalid-feedback');
           element.closest('.form-group').append(error);
         },
         highlight: function (element, errorClass, validClass) {
           $(element).addClass('is-invalid');
         },
         unhighlight: function (element, errorClass, validClass) {
           $(element).removeClass('is-invalid');
         }
       });
   });

  $("#aboutpage").validate({
            rules: {
                about_image_first:{
                  accept: "image/jpeg,image/png,image/jpg",
                }, 
                about_image_second:{
                  accept: "image/jpeg,image/png,image/jpg",
                }
            }
           
        });
    $("body").on('click', '#update-about-button', function() {
          $("input.about_image").each(function(){
           $(this).rules("add", {
               accept: "image/jpeg,image/png,image/jpg"
           });                    
     });
          if($("#update-home-page").valid())
      {
        let myForm = document.getElementById('aboutpage');
        myForm.submit();
      }
        });
</script>
@endsection