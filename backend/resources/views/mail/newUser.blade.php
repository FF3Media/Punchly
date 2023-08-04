<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>Email template</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <style type="text/css">
         @media screen {
         @font-face {
         font-family: 'Source Sans Pro';
         font-style: normal;
         font-weight: 400;
         src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
         }
         @font-face {
         font-family: 'Source Sans Pro';
         font-style: normal;
         font-weight: 700;
         src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
         }
         }
         body {
         width: 100% !important;
         height: 100% !important;
         padding: 0 !important;
         margin: 0 !important;
         }
         img {
         height: auto;
         line-height: 100%;
         text-decoration: none;
         border: 0;
         outline: none;
         }
      </style>
   </head>
   <body style="background-color: #e9ecef;">
      <!-- start body -->
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
         <tr>
            <td align="left" bgcolor="#e9ecef" style="height:20px;">
            </td>
         </tr>
         <!-- start logo -->
         <tr>
            <td align="center" bgcolor="#e9ecef">
               <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                     <td align="center" valign="top" style="background-color:#fff;padding: 20px 24px;">
                        <a href="#" target="_blank" style="display: inline-block;">
                        <img src="{{asset('front_end/images/logo.png')}}"   border="0" style="display: block;">
                        </a>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
         <!-- end logo -->
         <!-- start hero -->
         <tr>
            <td align="center" bgcolor="#e9ecef">
               <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                     <td align="center" bgcolor="#803a93" style="background-color:#803a93;padding: 20px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
                        <h1 style="color:#fff;margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Welcome To  Punchly
</h1>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
         <!-- end hero -->
         <!-- start block -->
         <tr>
            <td align="center" bgcolor="#e9ecef">
               <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <!-- start -->
                  <tr>
                     <td align="left" bgcolor="#ffffff" style="padding: 24px; padding-bottom:0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <h4 style="font-weight:500;margin-bottom:0;"><strong>From: </strong> <span><a href="#" target="_blank" style="text-decoration:none;color:#ac36d1;display: inline-block;">order@punchly.io</a></span> </h4>
                        <h4 style="font-weight:500;margin-top:5px;"><strong>Subject: </strong> <span>{{$data['subject']}}</span> </h4>
                     </td>
                  </tr>
                  <!-- end -->
                  <!-- start -->
                  <tr>
                     <td align="left" bgcolor="#ffffff" style="padding-top:0;padding-left: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <p style="margin: 0;margin-bottom:5px;"><strong>Hi, {{ isset($data) ? $data['first_name']: ''}}</strong></p>
                        <h4 style="font-weight:500;margin-top:0;margin-bottom:10px;"><strong>Name: </strong> <span> {{ isset($data) ? ucfirst($data['first_name']).' '.ucfirst($data['last_name']): '' }}</span> </h4>
                        <h4 style="font-weight:500;margin-top:0;margin-bottom:10px;"><strong>Email: </strong> <span> {{ isset($data) ? $data['email'] : '' }}</span> </h4>
                        <h4 style="font-weight:500;margin-top:0;margin-bottom:10px;"><strong>Phone: </strong> <span> {{ isset($data) ? $data['mobile'] : '' }}</span> </h4>
                        <h4 style="font-weight:500;margin-top:0;margin-bottom:10px;"><strong>Designation: </strong> <span> {{ isset($data) ? $data['user_role'] : '' }}</span> </h4>
                     </td>
                  </tr>
                  <!-- end -->
                  <!-- start -->
                  <tr>
                     <td align="left" bgcolor="#ffffff" style="padding-top:0;padding-left: 24px;padding-right: 24px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <p style="margin: 0;font-size:15px;">You will receive a second email to confirm your account, please ensure that you authenticate your email in order to be able to login to the Punchly digitization platform.</p>
                     </td>
                  </tr>
                  <!-- end copy -->
                  <!-- start -->
                   
                  <!-- end -->
                  <!-- start -->
                  <tr>
                     <td align="left" bgcolor="#ffffff" style="padding-top:0;padding-left: 24px; padding-bottom:24px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <p style="margin: 0;margin-bottom:5px;"><strong>Thanks</strong></p>
                     </td>
                  </tr>
                  <!-- end -->
               </table>
            </td>
         </tr>
         <!-- end block -->
         <tr>
            <td align="left" bgcolor="#e9ecef" style="height:20px;">
            </td>
         </tr>
      </table>
      <!-- end body -->
   </body>
</html>