import React ,{Component} from 'react';
import '../Main.css';
import { Link } from 'react-router-dom';
import { withRouter } from 'react-router-dom';
import axios from "../axios";
import Loading from "react-loader-spinner";
import ReactHtml from 'raw-html-react';
import Carousel from 'react-elastic-carousel';
import ServiceComponent from './Services';
import { Helmet } from 'react-helmet';
import MetaTags from 'react-meta-tags';

const breakPoints = [
    { width: 1, itemsToShow: 1 },
    { width: 550, itemsToShow: 2, itemsToScroll: 2 },
    { width: 768, itemsToShow: 3 },
    { width: 1200, itemsToShow: 4 }
  ];
class HomePage extends Component {
      constructor () {
        super()
        this.state = {
          getHomedata: {},
           loading: false,
           email: '',
            errors: {
                email: ''
            }
         }
      }
componentDidMount () { 
 this.setState({ loading: true }, () => {
    axios.get('/cms/cms-meta/1/').then(response => {
        this.setState({getHomedata : response.data.data,  loading: false })
        console.log("home22",response);
    }).catch(err => {
        console.log("ERROR: " + err);
    })
    }
)}

handleSubmit =  (event) => {
this.setState({ loading: true, succmessage : ''});
event.preventDefault();  
const email = this.state.email; 
    if(email == '' ){
       this.setState({loading: false})
      document.getElementById("email").style.display = "block";
      return false;
     }
    else { document.getElementById("email").style.display = "none";}
    if(validateForm(this.state.errors)) {
    const config = {     
    headers: { 'content-type': 'multipart/form-data' }
     }
        let formData = new FormData();
        formData.append('email', this.state.email);
        const url = '/cms/newsletter/'
        axios.post(url, formData, config)
            .then(response => {
            this.setState({loading: false})
            this.setState({email: '', succmessage : 'Thank you For Subscription'}); 
            document.getElementById("create-course-form").reset();  
            })
            .catch(error => {
                console.log(error);
            });
             console.info('Form Submitted')
            }else{
              console.error('Invalid Form')
            }
  }

handleChange = (event) => {
    event.preventDefault();
    const { name, value } = event.target;
    let errors = this.state.errors;  
    document.getElementById(name).style.display = "none";
        switch (name) {
        case 'email': 
        errors.email = 
          validEmailRegex.test(value)
            ? ''
            : 'Email is not valid!';
        break;
        default:
        break;
    }
    this.setState({errors, [name]: value});
  }

render () {
    const {getHomedata , errors, succmessage,loading} = this.state;
    const style = {textAlign: 'center',height: 600, flex: 1,marginTop:240, flex: 1,justifyContent: 'center',alignItems:'center'};  
     if(typeof getHomedata.cmsmetaapi == 'undefined'){
        return  <div style={style}>
        <Loading
        type="Puff"
        color="#2BC0BA"
        height={70}
        width={70}
        timeout={2000} //3 secs
      /></div>;
}


    const  Title =  getHomedata.title;
    const  Meta_tag =  getHomedata.meta_tag;
    const  Meta_description =  getHomedata.meta_description;
    const  BannerTitle =  getHomedata.cmsmetaapi.meta_value[0].banner_title;
    const  BannerDescription =  getHomedata.cmsmetaapi.meta_value[0].banner_description;
    const  BannerLink =  getHomedata.cmsmetaapi.meta_value[0].banner_button_link;    
    const  BannerButtonName =  getHomedata.cmsmetaapi.meta_value[0].banner_button_name;   
    const  BannerImageUrl =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].banner_image;     
    //const  FrontImageUrl =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].front_image; 
    const  FrontImageUrl =  '';   
    const  steps_main_heading =  getHomedata.cmsmetaapi.meta_value[0].steps_main_heading; 
    const  SectionTwoDescription =  getHomedata.cmsmetaapi.meta_value[0].section_two_description;    
    const  SectionthreeDescription =  getHomedata.cmsmetaapi.meta_value[0].section_three_left_description; 
    const  SectionthreeImage =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_three_right_image;  
    const  SectionthreeImagetitle =  getHomedata.cmsmetaapi.meta_value[0].alt_step_1_tag;  
    const  SectionFourDescription =  getHomedata.cmsmetaapi.meta_value[0].section_four_description;            
    const  SectionFourImage =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_four_image; 
    const  SectionFourImagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_2_tag; 
    const  SectionFiveDescription =  getHomedata.cmsmetaapi.meta_value[0].section_five_description;            
    const  SectionFiveImage =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_five_image; 
    const  SectionFiveImagetitle =  getHomedata.cmsmetaapi.meta_value[0].alt_step_3_tag; 
    const  SectionSixDescription =  getHomedata.cmsmetaapi.meta_value[0].section_six_description;            
    const  SectionSixImage =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_six_image;
    const  SectionSixImagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_4_tag;
   
    const  section_9_description =  getHomedata.cmsmetaapi.meta_value[0].section_9_description;            
    const  section_9_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_9_image; 
    const  section_9_imagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_5_tag; 
    
    const  section_10_description =  getHomedata.cmsmetaapi.meta_value[0].section_10_description;            
    const  section_10_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_10_image;   
    const  section_10_image_title =  getHomedata.cmsmetaapi.meta_value[0].alt_step_6_tag;   

    const  section_11_description =  getHomedata.cmsmetaapi.meta_value[0].section_11_description;            
    const  section_11_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_11_image;   
    const  section_11_image_title =   getHomedata.cmsmetaapi.meta_value[0].alt_step_7_tag;   

    const  section_12_description =  getHomedata.cmsmetaapi.meta_value[0].section_12_description;            
    const  section_12_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_12_image;   
    const  section_12_image_title =  getHomedata.cmsmetaapi.meta_value[0].alt_step_8_tag;   

    const  section_13_description =  getHomedata.cmsmetaapi.meta_value[0].section_13_description;            
    const  section_13_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_13_image;   
    const  section_13_image_title =  getHomedata.cmsmetaapi.meta_value[0].alt_step_9_tag;   

    const  section_14_description =  getHomedata.cmsmetaapi.meta_value[0].section_14_description;            
    const  section_14_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_14_image;   
    const  section_14_imagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_10_tag;  

    const  section_15_description =  getHomedata.cmsmetaapi.meta_value[0].section_15_description;            
    const  section_15_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_15_image;   
    const  section_15_imagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_111_tag; 

    const  section_16_description =  getHomedata.cmsmetaapi.meta_value[0].section_16_description;            
    const  section_16_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_16_image;   
    const  section_16_imagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_12_tag; 

    const  section_17_description =  getHomedata.cmsmetaapi.meta_value[0].section_17_description;            
    const  section_17_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_17_image;   
    const  section_17_imagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_13_tag; 

    const  section_18_description =  getHomedata.cmsmetaapi.meta_value[0].section_18_description;            
    const  section_18_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_18_image;   
    const  section_18_imagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_14_tag; 

    const  section_19_description =  getHomedata.cmsmetaapi.meta_value[0].section_19_description;            
    const  section_19_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_19_image;   
    const  section_19_imagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_15_tag; 

    const  section_20_description =  getHomedata.cmsmetaapi.meta_value[0].section_20_description;            
    const  section_20_image =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_20_image;   
    const  section_20_imagetitle =   getHomedata.cmsmetaapi.meta_value[0].alt_step_16_tag; 


    const  SectionSubscription =  getHomedata.cmsmetaapi.meta_value[0].section_seven_description;            
    const  SectionSubbackImage =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_seven_image;
    const  SectionEightDescription =  getHomedata.cmsmetaapi.meta_value[0].section_eight_description;            
    const  SectionEightImage =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_eight_image;     
    const  SectionEightImage_title =   getHomedata.cmsmetaapi.meta_value[0].alt_img_tag;   

    return ( 
        <>
        
     <div>
      <Helmet>
        <title>{Title}</title>
      </Helmet>
        </div>
        <MetaTags> 
            <meta id="meta-description" name="description" content={Meta_description} /> 
            <title>{Title}</title>         
            <meta id="og-title" property="og:title" content={Title} /> 
            <meta name="keywords" content={Meta_tag} />      
            <meta id="og-image" property="og:image" content={BannerImageUrl} />
           </MetaTags> 

   <section className='welcome' style={{
              backgroundImage: `url('${(BannerImageUrl && BannerImageUrl)}')`
            }}>
             
                <div className='container text-center'>
				<div className="row">
				<div className="col-xl-6 col-lg-6 col-md-12 col-sm-12"></div>
				<div className="col-xl-6 col-lg-6 col-md-12 col-sm-12">
				<div className="banner-text-box">
                <h1 className='text-white' dangerouslySetInnerHTML={{__html: BannerTitle}}  />            
                   <p className='text-white' dangerouslySetInnerHTML={{__html: BannerDescription}} />
                    <a className='btn btn-common bg-white' href={BannerLink}>{BannerButtonName}</a>
                    {FrontImageUrl && <div className='hero-img'>
                        <div className='hero-img-inner img-shadow'>
                            <img className='img-fluid' src={FrontImageUrl} alt='' />
                        </div>
                    </div> }
					</div>
					
					</div></div>
					
                </div>
            </section>
            

            <section className='how-work'>
                <div className='container'>
                    <div className='row'>
                <div className='w-100' dangerouslySetInnerHTML={{__html: SectionTwoDescription}} />
                    <div className="row">
                      <h2 className="sub-heading text-center w-100 mt-5 mb-0 text-uppercase">{steps_main_heading && steps_main_heading}</h2>
                        <div className='col-md-4 row m-0 align-items-center pt-custom pr-custom pt-5'>
                            <div className='col-md-12 col-sm-12 left-work p-0' dangerouslySetInnerHTML={{__html: SectionthreeDescription}} />
                               <div class='col-md-12 col-sm-12 p-0 d-inline-flex justify-content-end'>
                                <div class='img-shadow d-inline-block shadow-half shadow-bg-change'>
                             <a   href={'embroidery-digitizing/logo-digitizing'}>   <img class='img-fluid' src={SectionthreeImage} alt={SectionthreeImagetitle} /></a>
                                </div>
                            </div>
                         
                        </div>
                        <div className='col-md-4 row m-0 align-items-center pt-custom flex-row-reverse pr-custom pt-5'>
                        <div className='col-md-12 col-sm-12 p-0 left-work' dangerouslySetInnerHTML={{__html: SectionFourDescription}} />

                            <div className='col-md-12 col-sm-12 p-0'>
                                <div className='img-shadow d-inline-block shadow-half shadow-height-inc shadow-bg-change'>
                                 <a href={'embroidery-digitizing/custom-digitizing/'}>  
                                  <img className='img-fluid' src={SectionFourImage} alt={SectionFourImagetitle} /> 
                                  </a>
                                </div>
                            </div>
                        </div>
                        <div className='col-md-4 row m-0 align-items-center pt-custom pr-custom pt-5'>
                            <div className='col-md-12 col-sm-12 p-0 left-work' dangerouslySetInnerHTML={{__html: SectionFiveDescription}} />
                            <div className='col-md-12 col-sm-12 p-0 d-inline-flex justify-content-end'>
                                <div className='img-shadow d-inline-block shadow-half shadow-height-inc shadow-bg-change'>
                               <a href={'embroidery-digitizing/left-chest-digitizing/'}> 
                               <img className='img-fluid' src={SectionFiveImage && SectionFiveImage} alt={SectionFiveImagetitle} />
                                </a>
                                </div>
                            </div>
                        </div>
                        <div className='col-md-4 row m-0 align-items-center pt-custom flex-row-reverse pr-custom'>
                            <div className='col-md-12 col-sm-12 p-0 left-work' dangerouslySetInnerHTML={{__html: SectionSixDescription}} />
                            
                            <div className='col-md-12 col-sm-12 p-0'>
                                <div className='img-shadow d-inline-block shadow-half shadow-height-inc shadow-bg-change'>
                                 <a href={'embroidery-digitizing/jacket-back-digitizin/'}>   
                                 <img className='img-fluid' src={SectionSixImage && SectionSixImage} alt={SectionSixImagetitle} />
                                </a>
                                </div>
                            </div>
                        </div>

                        <div className='col-md-4 row m-0 align-items-center pt-custom flex-row-reverse pr-custom'>
                            <div className='col-md-12 col-sm-12 p-0 left-work' dangerouslySetInnerHTML={{__html: section_9_description}} />
                            
                            <div className='col-md-12 col-sm-12 p-0'>
                                <div className='img-shadow d-inline-block shadow-half shadow-height-inc shadow-bg-change'>
                                <a href={'embroidery-digitizing/applique-digitizing/'}>
                                    <img className='img-fluid' src={section_9_image && section_9_image} alt={section_9_imagetitle} />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div className='col-md-4 row m-0 align-items-center pt-custom flex-row-reverse pr-custom'>
                            <div className='col-md-12 col-sm-12 p-0 left-work' dangerouslySetInnerHTML={{__html: section_10_description}} />
                            
                            <div className='col-md-12 col-sm-12 p-0'>
                                <div className='img-shadow d-inline-block shadow-half shadow-height-inc shadow-bg-change'>
                                <a href={'embroidery-digitizing/wholesale-digitizing/'}>
                                    <img className='img-fluid' src={section_10_image && section_10_image} alt={section_10_image_title} />
                                 </a>
                                </div>
                            </div>
                        </div>
                        <div className='col-md-4 row m-0 align-items-center pt-custom flex-row-reverse pr-custom'>
                            <div className='col-md-12 col-sm-12 p-0 left-work' dangerouslySetInnerHTML={{__html: section_11_description}} />
                            
                            <div className='col-md-12 col-sm-12 p-0'>
                                <div className='img-shadow d-inline-block shadow-half shadow-height-inc shadow-bg-change'>
                                   <a href={'embroidery-digitizing/hand-drawn-logo-digitizing/'}>
                                    <img className='img-fluid' src={section_11_image && section_11_image} alt={section_11_image_title} />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div className='col-md-4 row m-0 align-items-center pt-custom flex-row-reverse pr-custom'>
                            <div className='col-md-12 col-sm-12 p-0 left-work' dangerouslySetInnerHTML={{__html: section_12_description}} />
                            
                            <div className='col-md-12 col-sm-12 p-0'>
                                <div className='img-shadow d-inline-block shadow-half shadow-height-inc shadow-bg-change'>
                                 <a href={'embroidery-digitizing/image-digitizing/'}>
                                    <img className='img-fluid' src={section_12_image && section_12_image} alt={section_12_image_title} />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div className='col-md-4 row m-0 align-items-center pt-custom flex-row-reverse pr-custom'>
                            <div className='col-md-12 col-sm-12 p-0 left-work' dangerouslySetInnerHTML={{__html: section_13_description}} />
                            
                            <div className='col-md-12 col-sm-12 p-0'>
                                <div className='img-shadow d-inline-block shadow-half shadow-height-inc shadow-bg-change'>
                                    <a href={'embroidery-digitizing/photo-digitizing/'}>
                                    <img className='img-fluid' src={section_13_image && section_13_image} alt={section_13_image_title}  />
                                     </a>
                                </div>
                            </div>
                        </div>
                       {section_14_description !='' ? <div className='col-md-4 row m-0 align-items-center pt-custom flex-row-reverse pr-custom'>
                            <div className='col-md-12 col-sm-12 p-0 left-work' dangerouslySetInnerHTML={{__html: section_14_description}} />
                            
                            <div className='col-md-12 col-sm-12 p-0'>
                                <div className='img-shadow d-inline-block shadow-half shadow-height-inc shadow-bg-change'>
                                <a href={'embroidery-digitizing/3d-puff-embroidery-digitizing/'}>
                                    <img className='img-fluid' src={section_14_image && section_14_image} alt={section_14_imagetitle} />
                                    </a>
                                </div>
                            </div>
                        </div> :'' }



                        </div>
                    </div>
                </div>
            </section>


            <section className='services-section'>
                <div className='container'>
                 <h2 className="sub-heading text-center w-100 mt-0 mb-5 text-uppercase">Why we're the best</h2>
                    <div className="row"> 
                        <div className='col-md-4 m-0 align-items-center service-grid'>
                         <div class='col-md-12 col-sm-12 p-0 d-inline-flex justify-content-end'>
                                <div class='img-shadow d-inline-block shadow-half shadow-bg-change'>
                             <img class='img-fluid' src='https://punchly.myfileshosting.com/images/custom-embroidery-digitizing.png'/> 
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 left-work p-0">
                             <h3 class="main-second-heading">Custom embroidery digitizing</h3>
                                <p>We are experts in making the highest quality embroidery machine ready files. </p></div>
                        </div>
                        
                       <div className='col-md-4 m-0 align-items-center service-grid'>
                         <div class='col-md-12 col-sm-12 p-0 d-inline-flex justify-content-end'>
                                <div class='img-shadow d-inline-block shadow-half shadow-bg-change'>
                              <img class='img-fluid' src='https://punchly.myfileshosting.com/images/fast-turn-around.png'/> 
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 left-work p-0"><h3 class="main-second-heading">Fast turn around</h3>
                                <p>We digitize our files within 2 hours, an industry benchmark. </p></div>
                        </div>
                        
                        
                       <div className='col-md-4 m-0 align-items-center service-grid'>
                         <div class='col-md-12 col-sm-12 p-0 d-inline-flex justify-content-end'>
                                <div class='img-shadow d-inline-block shadow-half shadow-bg-change'>
                             <img class='img-fluid' src='https://punchly.myfileshosting.com/images/quality-garanteed.png'/> 
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 left-work p-0"><h3 class="main-second-heading">Quality garanteed</h3>
                                <p>All of our digitized files go through a thorough 3 step quality control process to ensure that your file is right the first time. If it's not, we will remake it free of charge. </p></div>
                        </div>
                        
                        
                       <div className='col-md-4 m-0 align-items-center service-grid'>
                         <div class='col-md-12 col-sm-12 p-0 d-inline-flex justify-content-end'>
                                <div class='img-shadow d-inline-block shadow-half shadow-bg-change'>
                                 <img class='img-fluid' src='https://punchly.myfileshosting.com/images/friendly-customer-service.png'/> 
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 left-work p-0"><h3 class="main-second-heading">Friendly customer service</h3>
                                <p>Our North American based agents are happy to help you with any questions that you may have. </p></div>
                        </div>

                        <div className='col-md-4 m-0 align-items-center service-grid'>
                         <div class='col-md-12 col-sm-12 p-0 d-inline-flex justify-content-end'>
                                <div class='img-shadow d-inline-block shadow-half shadow-bg-change'>
                                  <img class='img-fluid' src='https://punchly.myfileshosting.com/images/best-business.png'/> 
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 left-work p-0"><h3 class="main-second-heading">Best in the business</h3>
                                <p>With over 20 years of combined digitization experience we know how to digitize your file right the first time. </p></div>
                        </div>
                        
                        <div className='col-md-4 m-0 align-items-center service-grid'>
                         <div class='col-md-12 col-sm-12 p-0 d-inline-flex justify-content-end'>
                                <div class='img-shadow d-inline-block shadow-half shadow-bg-change'>
                                 <img class='img-fluid' src='https://punchly.myfileshosting.com/images/cloud-storage.png'/> 
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 left-work p-0"><h3 class="main-second-heading">Cloud storage</h3>
                                <p>It's so easy to use. All of your digitized files are stored in the cloud so you can download them at anytime, anywhere. </p></div>
                        </div>
                    
                    </div>
                </div>
            </section>
            
                
                <section className='testimonials-home'>
                
                    <div className='container'>
                
                        <div className='row'>
                        <h2 class='sub-heading text-center w-100 mt-0 mb-5 text-uppercase'>WHAT PEOPLE SAY ABOUT US</h2>
                        
                            <div className='col-lg-6 col-md-6 col-sm-12 single-testimonial-col'>
                                <div className='single-testimmonials'>
                                  
                                    <div className='testimonials-text'>
                                    <blockquote><i> I have been using Punchly's services for 4 years now and I have no need to go anywhere else. </i></blockquote>
                                    <p><strong>Chris</strong> / Austin, TX</p>
                                    
                                    </div>
                                </div>
                            </div>
                            
                            <div className='col-lg-6 col-md-6 col-sm-12 single-testimonial-col'>
                                <div className='single-testimmonials'>
                                  
                                    <div className='testimonials-text'>
                                    <blockquote><i>Their customer service is so friendly, they remember my name when I call and are so easy to work with. </i></blockquote>
                                    <p><strong>Mel</strong> / New York, NY</p>
                                    
                                    </div>
                                </div>
                            </div>
                            
                            <div className='col-lg-6 col-md-6 col-sm-12 single-testimonial-col'>
                                <div className='single-testimmonials'>
                                   
                                    <div className='testimonials-text'>
                                    <blockquote><i>Very accomadating and helpful </i></blockquote>
                                    <p><strong>Karen</strong> / Bridgeport, CT</p>
                                    
                                    </div>
                                </div>
                            </div>
                            
                            <div className='col-lg-6 col-md-6 col-sm-12 single-testimonial-col'>
                                <div className='single-testimmonials'>
                                    
                                    <div className='testimonials-text'>
                                    <blockquote><i>Using Punchly is Hassle free. I love how I can have my files digitized with a few clicks of a button.</i></blockquote>
                                    <p><strong>Michael</strong> / Mansfield, Australia</p>
                                    
                                    </div>
                                </div>
                            </div>

                            <div className='col-lg-6 col-md-6 col-sm-12 single-testimonial-col'>
                                <div className='single-testimmonials'>
                                  
                                    <div className='testimonials-text'>
                                    <blockquote><i>Punchly's team is the best hands down. I always get my designs digitized right the first time. </i></blockquote>
                                    <p><strong>Jason</strong> / Manchester, UK</p>
                                    
                                    </div>
                                </div>
                            </div>

                            <div className='col-lg-6 col-md-6 col-sm-12 single-testimonial-col'>
                                <div className='single-testimmonials'>
                                   
                                    <div className='testimonials-text'>
                                    <blockquote><i>Their digitizing interface makes gettings my files digitized so easy. 10/10, I recommend them to all of my colleagues. </i></blockquote>
                                    <p><strong>Amanda</strong> / Edmonton, Canada</p>
                                    
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                
                    </div>
                
                </section>

        
         
            <section className='subscribe'  style={{
              backgroundImage: `url(${(SectionSubbackImage && SectionSubbackImage)})`
            }}>
                <div class="container">
                    <div class="row flex-column" dangerouslySetInnerHTML={{__html: SectionSubscription}} />                   
                     <form className='w-100 m-auto' id='create-course-form'>
                        <div className='align-items-center justify-content-between w-100'> 
                          <div className='form-group'>     
                             { succmessage ? <span className='succesmessage text-center'>{succmessage}</span> : ""  }                 
                           <input required  value={this.state.email} type='email' name="email" onChange={this.handleChange} noValidate placeholder='Enter Email Address' />
                           <span style={{display:'none',color: "red",position:"absolute"}} id="email">Please enter Email!</span>
                            {errors.email.length > 0 && <span style={{color: "red",position:"absolute"}} className='error'>{errors.email}</span>}
                            <button  type='submit' className='btn btn-common bg-white'  onClick={ (e) => { this.handleSubmit(e) }}>
                             {this.state.loading ? "Sending..." : "Subscribe"}
                          </button> 
                         </div>           
                        </div> 
                    </form>
                </div>
            </section>
            
            <div>
     
    </div>
        </>
    );
}
}
const validEmailRegex = RegExp(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i);
const validateForm = (errors) => {
  let valid = true;
  Object.values(errors).forEach(
    (val) => val.length > 0 && (valid = false)
  );
  return valid;
}
export default withRouter(HomePage);