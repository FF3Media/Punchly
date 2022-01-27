{{-- Extends layout --}}
@extends('layouts.app')
@php
$i=1;
@endphp
{{-- Content --}}
@section('content')
    <div class="container-fluid container-cms">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Home Page</h1>
            </div>
        </div>
    </div>
    <div class="container-fluid container-cms">
        <div class="row">
            <div class="col-lg-12">
                @if (session()->has('success'))
                    <div class="alert alert-success cus-msg-cls" style="text-align: left;">
                        {{ session()->get('success') }}
                    </div>
                @elseif(session()->has('failure'))
                    <div class="alert alert-danger cus-msg-cls" style="text-align: left;">
                        {{ session()->get('failure') }}
                    </div>
                @endif
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->

                        <!-- /.card-header -->
                        <!-- form start -->
                        @if (isset($homepage))
                            <form role="form" method="post"
                                action="{{ route('admin-update-home-page', ['id' => base64_encode($homepage['id'])]) }}"
                                id="homepage" name="homepage" enctype="multipart/form-data">
                        @endif
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">General Info</h3>
                            </div>
                            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label>Title <?php  base64_encode(1) ?></label>
                                        <input type="text" value="{{ isset($homepage) ? $homepage['title'] : '' }}"
                                            name="general_info[title]" class="form-control" id="title"
                                            placeholder="Please Enter Title">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Meta Title</label>
                                        <input type="text" value="{{ isset($homepage) ? $homepage['meta_title'] : '' }}"
                                            name="general_info[meta_title]" class="form-control" id="meta_title"
                                            placeholder="Please Enter Meta Title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label>Meta Tag</label>
                                        <input type="text" value="{{ isset($homepage) ? $homepage['meta_tag'] : '' }}"
                                            name="general_info[meta_tag]" class="form-control" id="meta_tag"
                                            placeholder="Please Enter Meta Tag">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Meta Description</label>
                                        <input type="text" value="{{ isset($homepage) ? $homepage['title'] : '' }}"
                                            name="general_info[meta_description]" class="form-control" id="meta_description"
                                            placeholder="Please Enter Meta Description">
                                    </div>
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
                                <h3 class="card-title">Manage Banner</h3>
                            </div>
                            <div class="card-body">
                                <div class="banner_content">
                                    @php
                                    $cms_meta = $banner_content['cmsmeta'];
                                    foreach($cms_meta as $banners):
                                    $bannerData = json_decode($banners->meta_value,true);
                                    foreach($bannerData as $key => $banner):
                                    @endphp
                                    <div class="add_banner_html">
                                        {{-- <div class="section-heading-home-inner">
                                            <h5>Slide {{ $i }}</h5>
                                        </div> --}}
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">
                                                {{-- <label>Banner Heading:</label>
                                                <input type="text" class="form-control"
                                                    value="{{ isset($banner['banner_small_heading']) ? $banner['banner_small_heading'] : '' }}"
                                                    name="banner_small_heading[{{ $i }}]" id="banner_small_heading"
                                                    placeholder="Enter banner heading"> --}}
                                                    <label>Banner Heading:</label>
                                                <input type="text" class="form-control"
                                                    value="{{ isset($banner['banner_title']) ? $banner['banner_title'] : '' }}"
                                                    name="banner_title[{{ $i }}]" id="banner_title"
                                                    placeholder="Enter banner title" required>
                                            </div>
                                            <div class="col-lg-6 my-error">                                               
                                                    <label>Banner Description:</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($banner['banner_description']) ? $banner['banner_description'] : '' }}"
                                                        name="banner_description[{{ $i }}]" id="banner_description"
                                                        placeholder="Enter banner description">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">
                                              <label>Banner Button Name:</label>
                                              <input type="text" class="form-control"
                                                  value="{{ isset($banner['banner_button_name']) ? $banner['banner_button_name'] : '' }}"
                                                  id="banner_button_name" name="banner_button_name[{{ $i }}]"
                                                  class="form-control" placeholder="Banner Button Name">
                                            </div>
                                            <div class="col-lg-6 my-error">
                                              <label>Banner Button Link:</label>
                                              <input type="text" class="form-control"
                                                  value="{{ isset($banner['banner_button_link']) ? $banner['banner_button_link'] : '' }}"
                                                  id="banner_button_link" name="banner_button_link[{{ $i }}]"
                                                  class="form-control" placeholder="Banner Button Link">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">
                                              <label>Banner Image:</label>
                                              <div class="input-group">
                                                  <div class="custom-file">
                                                      <input type="file" name="banner_image[{{ $i }}]" value=""
                                                          id="banner_image"
                                                          class="form-control banner_image custom-file-input"
                                                          placeholder="{{ isset($banner['banner_image']) ? $banner['banner_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['banner_image']) ? ' ' : 'required' }} />
                                                      <input type="hidden" name="old_banner_image[{{ $i }}]"
                                                          value="{{ isset($banner['banner_image']) ? $banner['banner_image'] : '' }}" />
       <label class="custom-file-label"
              for="banner_image">{{ isset($banner['banner_image']) ? $banner['banner_image'] : '' }}
            </label>
                                                  </div>
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
                                            <div class="col-lg-6 my-error" style="display:none">
                                              <label>Front Image:</label>
                                              <div class="input-group">
                                                  <div class="custom-file">
                                                      <input type="file" name="front_image[{{ $i }}]" value=""
                                                          id="front_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['front_image']) ? $banner['front_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['front_image']) ? ' ' : 'required' }} />

                                                      <input type="hidden" name="old_front_image[{{ $i }}]"
                                                          value="{{ isset($banner['front_image']) ? $banner['front_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="front_image">{{ isset($banner['front_image']) ? $banner['front_image'] : '' }}</label>
                                                  </div>
                                              </div>
                                        </div>
                                        <?php if ($key > 0): ?>
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">
                                                <button type="button" class="btn btn-danger removeBanner">Remove
                                                    Slide</button>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                  <div class="card card-primary">
                                      <div class="card-header">
                                      <h3 class="card-title">How it Works Section</h3>
                                      </div>
                                        <div class="card-body">
                                          <div class="banner_content">
                                          <div class="add_banner_html">
                                          <div class="form-group row">
                                          <div class="col-lg-12 my-error">                                                
                                          <label>Section two Description:</label>
                                          <textarea class="form-control editor" name="section_two_description"   id="section_two_description">{{ isset($banner['section_two_description']) ? $banner['section_two_description'] : '' }}</textarea>
                                          </div>

                                        </div> 
                                      </div>

                                    </div>

                                    </div>
                                  <!-- /.card-body -->

                                  </div>
                             <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step's Main Heading</h3>
                                </div>
                                <div class="card-body">
                                  <div class="banner_content">
                                        <div class="form-group row">
                                            <div class="col-lg-12 my-error">
                                              <label>Main Heading:</label>
                                              <input type="text" class="form-control"
                                                  value="{{ isset($banner['steps_main_heading']) ? $banner['steps_main_heading'] : '' }}"
                                                  id="steps_main_heading" name="steps_main_heading"
                                                  class="form-control" placeholder="Main Heading">
                                            </div>
                                          </div>
                                  </div>
                                </div>
                             </div> 
                            <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 1</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                  
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_three_left_description"     id="section_three_description">{{ isset($banner['section_three_left_description']) ? $banner['section_three_left_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_three_right_image[{{ $i }}]" value=""
                                                          id="section_three_right_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_three_right_image']) ? $banner['section_three_right_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_three_right_image']) ? ' ' : 'required' }} />
                                                          
                                                  <input type="hidden" name="old_section_three_right_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_three_right_image']) ? $banner['section_three_right_image'] : '' }}"/>

                                                  <label class="custom-file-label" for="section_three_right_image">
                                                        {{ isset($banner['section_three_right_image']) ? $banner['section_three_right_image'] : '' }}
                                                  </label>

                                                  </div>
                                            </div>
                                        </div> 
 <div class="form-group row">
 <div class="col-lg-6 my-error"> 
   <label>Step 1 Image Alt Tag Text:</label>
   <input type="text" class="form-control"
    value="{{isset($banner['alt_step_1_tag']) ? $banner['alt_step_1_tag'] : '' }}"
    id="alt_step_1_tag" name="alt_step_1_tag[{{ $i }}]" class="form-control" 
    placeholder="Step 1 Image Alt Tag Text">
</div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 2</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_four_description"     id="section_three_description">{{ isset($banner['section_four_description']) ? $banner['section_four_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_four_image[{{ $i }}]" value=""
                                                          id="section_four_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_four_image']) ? $banner['section_four_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_four_image']) ? ' ' : 'required' }} />
                                                          
                                                      <input type="hidden" name="old_section_four_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_four_image']) ? $banner['section_four_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_four_image">{{ isset($banner['section_four_image']) ? $banner['section_four_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
<div class="form-group row">
 <div class="col-lg-6 my-error"> 
  <label>Step 2 Image Alt Tag Text:</label>
   <input type="text" class="form-control"
   value="{{isset($banner['alt_step_2_tag']) ? $banner['alt_step_2_tag'] : '' }}"
   id="alt_step_2_tag" name="alt_step_2_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 2 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                    <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 3</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_five_description"     id="section_three_description">{{ isset($banner['section_five_description']) ? $banner['section_five_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_five_image[{{ $i }}]" value=""
                                                          id="section_five_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_five_image']) ? $banner['section_five_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_five_image']) ? ' ' : 'required' }} />
                                                          
                                                      <input type="hidden" name="old_section_five_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_five_image']) ? $banner['section_five_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_five_image">{{ isset($banner['section_five_image']) ? $banner['section_five_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
  <div class="form-group row">
 <div class="col-lg-6 my-error"> 
  <label>Step 3 Image Alt Tag Text:</label>
   <input type="text" class="form-control"
   value="{{isset($banner['alt_step_3_tag']) ? $banner['alt_step_3_tag'] : '' }}"
   id="alt_step_3_tag" name="alt_step_3_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 3 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 4</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_six_description"     id="section_three_description">{{ isset($banner['section_six_description']) ? $banner['section_six_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_six_image[{{ $i }}]" value=""
                                                          id="section_six_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_six_image']) ? $banner['section_six_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_six_image']) ? ' ' : 'required' }} />
                                                          
                                                      <input type="hidden" name="old_section_six_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_six_image']) ? $banner['section_six_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_six_image">{{ isset($banner['section_six_image']) ? $banner['section_six_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 

 <div class="form-group row">
 <div class="col-lg-6 my-error"> 
  <label>Step 4 Image Alt Tag Text:</label>
   <input type="text" class="form-control"
   value="{{isset($banner['alt_step_4_tag']) ? $banner['alt_step_4_tag'] : '' }}"
   id="alt_step_4_tag" name="alt_step_4_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 4 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 5</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_9_description"     id="section_three_description">{{ isset($banner['section_9_description']) ? $banner['section_9_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_9_image[{{ $i }}]" value=""
                                                          id="section_9_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_9_image']) ? $banner['section_9_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_9_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_9_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_9_image']) ? $banner['section_9_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_9_image">{{ isset($banner['section_9_image']) ? $banner['section_9_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
<div class="form-group row">
 <div class="col-lg-6 my-error"> 
  <label>Step 5 Image Alt Tag Text:</label>
   <input type="text" class="form-control"
   value="{{isset($banner['alt_step_5_tag']) ? $banner['alt_step_5_tag'] : '' }}"
   id="alt_step_5_tag" name="alt_step_5_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 5 Image Alt Tag Text">
 </div>
</div>

                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 6</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_10_description"     id="section_three_description">{{ isset($banner['section_10_description']) ? $banner['section_10_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_10_image[{{ $i }}]" value=""
                                                          id="section_10_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_10_image']) ? $banner['section_10_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_10_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_10_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_10_image']) ? $banner['section_10_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_10_image">{{ isset($banner['section_10_image']) ? $banner['section_10_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
<div class="form-group row">
 <div class="col-lg-6 my-error"> 
  <label>Step 6 Image Alt Tag Text:</label>
   <input type="text" class="form-control"
   value="{{isset($banner['alt_step_6_tag']) ? $banner['alt_step_6_tag'] : '' }}"
   id="alt_step_6_tag" name="alt_step_6_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 6 Image Alt Tag Text">
 </div>
</div>

                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 7</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_11_description"     id="section_three_description">{{ isset($banner['section_11_description']) ? $banner['section_11_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_11_image[{{ $i }}]" value=""
                                                          id="section_11_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_11_image']) ? $banner['section_11_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_11_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_11_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_11_image']) ? $banner['section_11_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_11_image">{{ isset($banner['section_11_image']) ? $banner['section_11_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
<div class="form-group row">
 <div class="col-lg-6 my-error"> 
  <label>Step 7 Image Alt Tag Text:</label>
   <input type="text" class="form-control"
   value="{{isset($banner['alt_step_7_tag']) ? $banner['alt_step_7_tag'] : '' }}"
   id="alt_step_7_tag" name="alt_step_7_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 7 Image Alt Tag Text">
 </div>
</div>


                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 8</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_12_description"     id="section_three_description">{{ isset($banner['section_12_description']) ? $banner['section_12_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_12_image[{{ $i }}]" value=""
                                                          id="section_12_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_12_image']) ? $banner['section_12_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_12_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_12_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_12_image']) ? $banner['section_12_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_12_image">{{ isset($banner['section_12_image']) ? $banner['section_12_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
  <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 8 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_8_tag']) ? $banner['alt_step_8_tag'] : '' }}"
   id="alt_step_8_tag" name="alt_step_8_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 8 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 9</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_13_description"     id="section_three_description">{{ isset($banner['section_13_description']) ? $banner['section_13_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_13_image[{{ $i }}]" value=""
                                                          id="section_13_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_13_image']) ? $banner['section_13_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_13_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_13_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_13_image']) ? $banner['section_13_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_13_image">{{ isset($banner['section_13_image']) ? $banner['section_13_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
 <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 9 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_9_tag']) ? $banner['alt_step_9_tag'] : '' }}"
   id="alt_step_9_tag" name="alt_step_9_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 9 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 10</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_14_description"     id="section_three_description">{{ isset($banner['section_14_description']) ? $banner['section_14_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_14_image[{{ $i }}]" value=""
                                                          id="section_14_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_14_image']) ? $banner['section_14_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_14_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_14_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_14_image']) ? $banner['section_14_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_14_image">{{ isset($banner['section_14_image']) ? $banner['section_14_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
    <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 10 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_10_tag']) ? $banner['alt_step_10_tag'] : '' }}"
   id="alt_step_10_tag" name="alt_step_10_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 10 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 
                    <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 11</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_15_description"     id="section_three_description">{{ isset($banner['section_15_description']) ? $banner['section_15_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_15_image[{{ $i }}]" value=""
                                                          id="section_15_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_15_image']) ? $banner['section_15_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_15_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_15_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_15_image']) ? $banner['section_15_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_15_image">{{ isset($banner['section_15_image']) ? $banner['section_15_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
    <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 11 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_111_tag']) ? $banner['alt_step_111_tag'] : '' }}"
   id="alt_step_111_tag" name="alt_step_111_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 11 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 
                    <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 12</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_16_description"     id="section_three_description">{{ isset($banner['section_16_description']) ? $banner['section_16_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_16_image[{{ $i }}]" value=""
                                                          id="section_16_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_16_image']) ? $banner['section_16_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_16_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_16_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_16_image']) ? $banner['section_16_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_16_image">{{ isset($banner['section_16_image']) ? $banner['section_16_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
    <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 12 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_12_tag']) ? $banner['alt_step_12_tag'] : '' }}"
   id="alt_step_12_tag" name="alt_step_12_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 12 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                       <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 13</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_17_description"     id="section_three_description">{{ isset($banner['section_17_description']) ? $banner['section_17_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_17_image[{{ $i }}]" value=""
                                                          id="section_17_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_17_image']) ? $banner['section_17_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_17_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_17_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_17_image']) ? $banner['section_17_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_17_image">{{ isset($banner['section_17_image']) ? $banner['section_17_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
    <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 13 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_13_tag']) ? $banner['alt_step_13_tag'] : '' }}"
   id="alt_step_13_tag" name="alt_step_13_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 13 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 



                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 14</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_18_description"     id="section_three_description">{{ isset($banner['section_18_description']) ? $banner['section_18_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_18_image[{{ $i }}]" value=""
                                                          id="section_18_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_18_image']) ? $banner['section_18_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_18_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_18_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_18_image']) ? $banner['section_18_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_18_image">{{ isset($banner['section_18_image']) ? $banner['section_18_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
    <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 14 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_14_tag']) ? $banner['alt_step_14_tag'] : '' }}"
   id="alt_step_14_tag" name="alt_step_14_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 14 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                       


                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 15</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                    
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_19_description"     id="section_three_description">{{ isset($banner['section_19_description']) ? $banner['section_19_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_19_image[{{ $i }}]" value=""
                                                          id="section_19_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_19_image']) ? $banner['section_19_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_19_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_19_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_19_image']) ? $banner['section_19_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_19_image">{{ isset($banner['section_19_image']) ? $banner['section_19_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
    <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 15 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_15_tag']) ? $banner['alt_step_15_tag'] : '' }}"
   id="alt_step_15_tag" name="alt_step_15_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 15 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

<div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 16</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                    
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_20_description"     id="section_three_description">{{ isset($banner['section_20_description']) ? $banner['section_20_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_20_image[{{ $i }}]" value=""
                                                          id="section_20_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_20_image']) ? $banner['section_20_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_20_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_20_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_20_image']) ? $banner['section_20_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_20_image">{{ isset($banner['section_20_image']) ? $banner['section_20_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
    <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 16 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_16_tag']) ? $banner['alt_step_16_tag'] : '' }}"
   id="alt_step_16_tag" name="alt_step_16_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 16 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 


<div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Step 17</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                    
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_21_description"     id="section_three_description">{{ isset($banner['section_21_description']) ? $banner['section_21_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_21_image[{{ $i }}]" value=""
                                                          id="section_21_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_21_image']) ? $banner['section_21_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_21_image']) ? ' ' : '' }} />
                                                          
                                                      <input type="hidden" name="old_section_21_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_21_image']) ? $banner['section_21_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_21_image">{{ isset($banner['section_21_image']) ? $banner['section_21_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 
    <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Step 17 Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_17_tag']) ? $banner['alt_step_17_tag'] : '' }}"
   id="alt_step_17_tag" name="alt_step_17_tag[{{ $i }}]" class="form-control" 
   placeholder="Step 17 Image Alt Tag Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 



                    <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Newsletter</h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_seven_description"     id="section_three_description">{{ isset($banner['section_seven_description']) ? $banner['section_seven_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Backgrauund Image</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_seven_image[{{ $i }}]" value=""
                                                          id="section_seven_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_seven_image']) ? $banner['section_seven_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_seven_image']) ? ' ' : 'required' }} />
                                                          
                                                      <input type="hidden" name="old_section_seven_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_seven_image']) ? $banner['section_seven_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_seven_image">{{ isset($banner['section_seven_image']) ? $banner['section_seven_image'] : '' }}</label>
                                                  </div>
                                            </div>
                                        </div> 

    <div class="form-group row">
    <div class="col-lg-6 my-error"> 
    <label>Newsletter Image Alt Tag Text:</label>
    <input type="text" class="form-control"
   value="{{isset($banner['alt_step_11_tag']) ? $banner['alt_step_11_tag'] : '' }}"
   id="alt_step_11_tag" name="alt_step_11_tag[{{ $i }}]" class="form-control" 
   placeholder="Newsletter Image Alt Text">
 </div>
</div>
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 
                     <div class="card card-primary">
                                <div class="card-header">
                                <h3 class="card-title">Seo Section </h3>
                                </div>
                            <div class="card-body">
                                    <div class="banner_content">
                                        <div class="add_banner_html">
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                
                                                <label>Description:</label>
                                                <textarea class="form-control editor" name="section_eight_description"     id="section_three_description">{{ isset($banner['section_eight_description']) ? $banner['section_eight_description'] : '' }}</textarea>
                                            </div>
                                             <div class="col-lg-6 my-error">  
                                              <label>Image:</label>                                              
                                               <div class="custom-file">
                                                      <input type="file" name="section_eight_image[{{ $i }}]" value=""
                                                          id="section_eight_image"
                                                          class="form-control front_image custom-file-input"
                                                          placeholder="{{ isset($banner['section_eight_image']) ? $banner['section_eight_image'] : 'Browse Image' }}"
                                                          accept="image/*"
                                                          {{ isset($banner['section_eight_image']) ? ' ' : 'required' }} />
                                                          
                                                      <input type="hidden" name="old_section_eight_image[{{ $i }}]"
                                                          value="{{ isset($banner['section_eight_image']) ? $banner['section_eight_image'] : '' }}" />
                                                      <label class="custom-file-label"
                                                          for="section_seven_image">{{ isset($banner['section_eight_image']) ? $banner['section_eight_image'] : '' }}</label>
                                                  </div>
                                            </div>
<div class="col-lg-6 my-error"> 
 <label>Seo Image Alt Tag Text:</label>
 <input type="text" class="form-control"
 value="{{ isset($banner['alt_img_tag']) ? $banner['alt_img_tag'] : '' }}"
 id="alt_img_tag" name="alt_img_tag[{{ $i }}]"
 class="form-control" placeholder="Seo Image Alt Tag Text">
</div>


                                        </div> 
                                    </div>

                                    </div>

                            </div>
                            <!-- /.card-body -->

                    </div> 

                                    @php
                                    $i++;
                                    endforeach;
                                    endforeach;
                                    @endphp
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-lg-12 my-error">
                                        <button id="addMoreBanner" type="button"
                                            class="btn btn-success btn-sm float-right green-bg"> Add New Slide</button>
                                    </div>
                                </div> --}}
                            </div>
                          
                            <div class="card-footer">
                                <button type="submit" id="update-home-button" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        </form>
                        <!-- /.card -->
                    </div>
                  
                </div>


            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // CKEDITOR.replace('home_appp_description');

            $('#homepage').validate({
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
                    meta_title: {
                        required: true,
                    },
                    meta_description: {
                        required: true,
                    },
                    section_three_left_description: {
                        required: true,
                    },

                    content: {
                        required: function() {
                            // CKEDITOR.instances.home_appp_description.updateElement();
                        },
                        minlength: 1
                    },
                },
                messages: {
                    title: {
                        required: "Please enter title.",
                    },
                    meta_tag: {
                        required: "Please enter meta tag.",
                    },
                    home_appp_description: {
                        required: "Please enter content",
                    },
                    meta_title: {
                        required: "Please enter meta title."
                    },
                    meta_description: {
                        required: "Please enter meta description."
                    },
                    section_three_left_description: {
                        required: "Please enter meta description."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });


        var i = '<?= $i ?>';
        var html = '';
        $(document).on('click', '#addMoreBanner', function() {
            html = `<div class="add_banner_html">
                                <div class="section-heading-home-inner">
                                            <h5>Slide {{ $i }}</h5>
                                           </div>
                              <div class="form-group row">
                    <div class="col-lg-6 my-error">
                      <label>Banner Heading:</label>
                      <input type="text" class="form-control" value="" name="banner_small_heading[{{ $i }}]" id="banner_small_heading" placeholder="Enter banner heading">
                    </div>
                    <div class="col-lg-6 my-error">
                      <label>Banner Title:</label>
                      <input type="text" class="form-control" value="" name="banner_title[{{ $i }}]" id="banner_title" placeholder="Enter banner title" required>
                    </div>                        
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-6 my-error">
                      <label>Banner Description:</label>
                      <input type="text" class="form-control" value="" name="banner_description[{{ $i }}]" id="banner_description" placeholder="Enter banner description">
                    </div>          
                    <div class="col-lg-6 my-error">
                      <label>Banner Image:</label>
                      <input type="file" name="banner_image[{{ $i }}]"  value="" id="banner_image" class="form-control banner_image" placeholder="Browse Image" required />
                    </div>
                  </div>
                                 <div class="form-group row">           
                    <div class="col-lg-6 my-error">
                      <label>Banner Button Name:</label>
                      <input type="text" class="form-control" value="" id="banner_button_name" name="banner_button_name[{{ $i }}]" class="form-control" placeholder="Banner Button Name">
                    </div>  
                              <div class="col-lg-6 my-error">
                      <label>Banner Button Link:</label>
                      <input type="text" class="form-control" value="" id="banner_button_link" name="banner_button_link[{{ $i }}]" class="form-control" placeholder="Banner Button Link">
                    </div>  
                    
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-6 my-error">
                      <button type="button" class="btn btn-danger removeBanner">Remove</button>
                    </div>  
                      
                  </div>
                  </div>`;
            $('.banner_content').append(html).slideDown("slow");
            i++;
        });
        $(document).on('click', '.removeBanner', function() {
            $this = $(this);
            $this.closest(".add_banner_html").remove();

        });

        $("#homepage").validate({
            rules: {
                explore_video_image: {
                    accept: "image/jpeg,image/png,image/jpg",
                },
                explore_background_image: {
                    accept: "image/jpeg,image/png,image/jpg",
                },
                explore_video: {
                    extension: "mpeg|ogg|mp4|webm|3gp|mov|flv|avi|wmv|ts",

                },
            }

        });
        $("body").on('click', '#update-home-button', function() {
            $("input.banner_image").each(function() {
                $(this).rules("add", {
                    accept: "image/jpeg,image/png,image/jpg"
                });
            });
            if ($("#update-home-page").valid()) {
                let myForm = document.getElementById('homepage');
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
