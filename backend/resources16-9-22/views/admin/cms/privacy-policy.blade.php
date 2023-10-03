@extends('layouts.app')
@php
$i=1;
@endphp
@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid container-cms">
         <div class="row mb-2">
            <div class="col-sm-12">
               <h1>Privacy Policy</h1>
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
                  @if(isset($privacyPolicy))
                  <form role="form" method="post" action="{{ route('admin-update-privacy-policy-page',['id' => base64_encode($privacyPolicy['id'])]) }}" id="privacyPolicy" name="privacyPolicy" enctype="multipart/form-data">
                  @endif
                  <div class="card card-primary">
                    <div class="card-header">
                       <h3 class="card-title">General Info</h3>
                    </div>
                     <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                     <div class="card-body">
                        <div class="form-group">
                           <label>Title</label>
                           <input type="text" value="{{ isset($privacyPolicy) ? $privacyPolicy['title'] : '' }}" name="general_info[title]" class="form-control" id="title" placeholder="Please Enter Title">
                        </div>
                        <div class="form-group">
                           <label>Meta Title</label>
                           <input type="text" value="{{ isset($privacyPolicy) ? $privacyPolicy['meta_title'] : '' }}" name="general_info[meta_title]" class="form-control" id="meta_title" placeholder="Please Enter Meta Title">
                        </div>
                        <div class="form-group">
                           <label>Meta Tag</label>
                           <input type="text" value="{{ isset($privacyPolicy) ? $privacyPolicy['meta_tag'] : '' }}" name="general_info[meta_tag]" class="form-control" id="meta_tag" placeholder="Please Enter Meta Tag">
                        </div>
                        <div class="form-group">
                           <label>Meta Description</label>
                           <input type="text" value="{{ isset($privacyPolicy) ? $privacyPolicy['meta_description'] : '' }}" name="general_info[meta_description]" class="form-control" id="meta_description" placeholder="Please Enter Meta Description">
                        </div> 
                        <div class="form-group row">  
                        <div class="col-lg-6 my-error">
                           <label>Slug:</label>
                           <input type="text" class="form-control"
                                                    value="{{ isset($cmsmeta) ? $cmsmeta->slug : '' }}"
                                                    name="slug" id="slug"
                                                    placeholder="Enter Slug" required>
                        </div>                                    
                           </div> 
                     </div>
                     <!-- /.card-body --> 
                     
                  </div>
                   <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Manage Privacy Policy Cms</h3>
                            </div>
                            <div class="card-body">
                                <div class="contact_us_content">
                                    @php
                                    $cms_meta = $privacy_policy_content['cmsmeta'];
                                    foreach($cms_meta as $banners):
                                    $bannerData = json_decode($banners->meta_value,true);
                                    foreach($bannerData as $key => $banner):
                                    @endphp
                                    <div class="add_banner_html">                                         
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">
                                                 
                                                <label>Heading:</label>
                                                <input type="text" class="form-control"
                                                    value="{{ isset($banner['title']) ? $banner['title'] : '' }}"
                                                    name="title[{{ $i }}]" id="title"
                                                    placeholder="Enter title" required>
                                            </div> 
                                            
          <div class="col-lg-6 my-error">
                     <label>Banner Image:</label>
                  <div class="input-group">
                 <div class="custom-file">
                     <input type="file"
                      name="banner_image[{{ $i }}]" value=""
                     id="banner_image"
                      class="form-control banner_image custom-file-input"
                      placeholder="{{ isset($banner['banner_image']) ? $banner['banner_image'] : 'Browse Image' }}"
                     accept="image/*"
                 {{ isset($banner['banner_image']) ? ' ' : 'required' }} />
                   <input type="hidden" name="old_banner_image[{{ $i }}]"
                                                          value="{{ isset($banner['banner_image']) ? $banner['banner_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="banner_image">{{ isset($banner['banner_image']) ? $banner['banner_image'] : '' }}</label>
                                                  </div>
                                              </div>
                                            </div>                                                                                      
                                         </div>     
                                          <div class="form-group row">              
                                            
                                          <div class="col-lg-6 my-error">               
                                                <label>Content:</label>
                                                <textarea class="form-control editor" name="content" id="content">{{ isset($banner['content']) ? $banner['content'] : '' }}</textarea>
                                            </div>                         


                                         </div> 
        <div class="col-lg-6 my-error"> 
 <label>Banner Image Alt Tag Text:</label>
 <input type="text" class="form-control"
  value="{{ isset($banner['alt_banner_tag']) ? $banner['alt_banner_tag'] : '' }}"
  id="alt_banner_tag" 
  name="alt_banner_tag[{{ $i }}]"
  class="form-control" 
  placeholder="Banner Image Alt Tag Text">
</div>   
                                    </div>
                                      
                                   
                                  </div>
                                  @php
                                    $i++;
                                    endforeach;
                                    endforeach;
                                    @endphp
                                  </div>
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
   $(document).ready(function () {
      $('#privacyPolicy').validate({
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
         },
         messages: {
           title: {
             required: "Please enter title.",
           },
           meta_tag: {
             required: "Please enter meta tag.",
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

 

    $("#privacyPolicy").validate({
            rules: {
                explore_video_image:{
                  accept: "image/jpeg,image/png,image/jpg",
                }, 
                explore_background_image:{
                  accept: "image/jpeg,image/png,image/jpg",
                },
                 explore_video:{
                  extension: "mpeg|ogg|mp4|webm|3gp|mov|flv|avi|wmv|ts",
    
                },
            }
           
        });
    $("body").on('click', '#update-home-button', function() {
          $("input.banner_image").each(function(){
           $(this).rules("add", {
               accept: "image/jpeg,image/png,image/jpg"
           });                    
     });
          if($("#update-home-page").valid())
      {
        let myForm = document.getElementById('privacyPolicy');
        myForm.submit();
      }
        });


    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': decodeURIComponent(/XSRF-Token=([^;]*)/ig.exec(document.cookie)[1])
        }
    });
        $('.editor').summernote({

        placeholder: '',
        tabsize: 2,
        height: 250,
         popover: {
        image: [
            ['remove', ['removeMedia']]
        ],
                },
        toolbar: [
          ['font', ['bold']],
          ['para', ['ul', 'ol']],
          ['insert', ['video', 'link', 'picture']],
          ['view', ['codeview', 'help']]
        ],
        codemirror: { // codemirror options
        theme: 'monokai'
      },
        callbacks: {
            onImageUpload : function(files, editor, welEditable) {

                for(var i = files.length - 1; i >= 0; i--) {
                     sendFile(files[i], this);
                }
            }
    }
          });

         

        function sendFile(file, editor) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "{{route('admin-upload-home-image')}}",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    
                     $(editor).summernote('editor.insertImage', url, function ($image) {
               // $image.css('width', $image.width() / 2);
                $image.addClass('editor-image');
            });
                }
            });
        }
</script>
@endsection