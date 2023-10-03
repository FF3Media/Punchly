import React ,{Component} from 'react';
import { withRouter } from 'react-router-dom';
import { Link } from 'react-router-dom';
import Fbicon from '../images/fb-icon.png';
import Twittericon from '../images/twitter.png';
import Instaicon from '../images/instagram.png';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faEnvelope} from "@fortawesome/free-regular-svg-icons";
import {faPhone, faMapMarker} from "@fortawesome/free-solid-svg-icons";
import axios from "../axios";
import Loading from "react-loader-spinner";

class Contact extends Component {
      constructor (props) {
        super(props)
        this.state = {
             getContactdata: {},
             loading:true,
             firstname: '',
              lastname: '',
              email: '',
              phone: '',
              message: '',
               succmessage: '',
              errors: {
                firstname: '',
                lastname: '',
                email: '',
                phone: '',
                message: ''
              },
              err : []
        };
      }
componentDidMount () {
this.setState({ loading: true }, () => {
axios.get('/cms/cms-meta/2/').then(response => {
        this.setState({ getContactdata : response.data.data, loading : false }, () => {});
}).catch(err => {
    console.log("ERROR: " + err);
 });
});
window.scrollTo(0, 0)
}
handleChange = (event) => {
    event.preventDefault();
    const { name, value } = event.target;
    let errors = this.state.errors;  
    document.getElementById(name).style.display = "none";
    switch (name) {
      case 'firstname': 
        errors.firstname = 
          value.length < 1
            ? 'Please enter first name'
            : '';
        break; 
        case 'lastname': 
        errors.lastname = 
          value.length < 1
            ? 'Please enter last name'
            : '';
        break;
      case 'email': 
        errors.email = 
          validEmailRegex.test(value)
            ? ''
            : 'Email is not valid!';
        break;
      case 'phone': 
        errors.phone = 
          value.length < 8
            ? 'Please enter valid phone number'
            : '';
        break;
        case 'message': 
        errors.message = 
          value.length < 5
            ? 'Minimum length should be 5 characters'
            : '';
        break;
      default:
        break;
    }
    this.setState({errors, [name]: value});
  }

  handleSubmit = async (event) => {
     this.setState({ loading: true });
    event.preventDefault();   
    const fname = this.state.firstname;
    const lname = this.state.lastname;
    const phone = this.state.phone;
    const email = this.state.email;
    const message = this.state.message;
    if(fname == '' ){
       this.setState({loading: false})
      document.getElementById("firstname").style.display = "block";
      return false;
     }
    if(fname == '' ){
       this.setState({loading: false})
      document.getElementById("firstname").style.display = "block";
      return false;
     }
     else { document.getElementById("firstname").style.display = "none";}

    if(lname == '' ){
       this.setState({loading: false})
      document.getElementById("lastname").style.display = "block";
      return false;
     }
     else { document.getElementById("lastname").style.display = "none";}

    if(email == '' ){
       this.setState({loading: false})
      document.getElementById("email").style.display = "block";
      return false;
     }
   else  if(ValidateEmail(this.state.email) == false  ){
    this.setState({loading: false})
    return false;

     }
    else { document.getElementById("email").style.display = "none";}

    if(phone == '' ){
       this.setState({loading: false})
      document.getElementById("phone").style.display = "block";
      return false;
     }
     else { document.getElementById("phone").style.display = "none";}

    if(validateForm(this.state.errors)) {
    const config = {     
    headers: { 'content-type': 'multipart/form-data' }
     }
        let formData = new FormData();
        formData.append('firstname', this.state.firstname);
        formData.append('lastname', this.state.lastname);
        formData.append('email', this.state.email);
        formData.append('phone', this.state.phone);
        formData.append('message', this.state.message);
        const url = '/cms/contact-mail/'
       await axios.post(url, formData, config)
            .then(response => {
            this.setState({loading: false})
            this.setState({succmessage : 'Thank you for getting in touch. We’ll get back to you within the next business day.'}); 
            document.getElementById("create-course-form").reset();          
            setTimeout(function(){ window.location.reload(false);}, 2000);             
            })
            .catch(error => {
                console.log(error);
            });
             console.info('Form Submitted')
            }else{
              console.error('Invalid Form')
            }
  }
render () {
const { getContactdata, errors, succmessage, loading } = this.state;
const style = {textAlign: 'center',height: 600, flex: 1,marginTop:240, flex: 1,justifyContent: 'center',alignItems:'center'};  
if(Object.keys(getContactdata).length < 1 ||  typeof getContactdata == 'undefined') {
    return <div style={style}><Loading 
        type="Puff"
        color="#00BFFF"
        height={70}
        width={70}
        timeout={2000} 
      /></div>;

} 
const contact_info = getContactdata.cmsmetaapi.meta_value[0].title
const sub_heading = getContactdata.cmsmetaapi.meta_value[0].sub_heading
const description = getContactdata.cmsmetaapi.meta_value[0].description
const ph_info = getContactdata.cmsmetaapi.meta_value[0].contact_info
const email = getContactdata.cmsmetaapi.meta_value[0].email;
const address = getContactdata.cmsmetaapi.meta_value[0].address;
const BannerImageUrl =  getContactdata.home_path+'/'+getContactdata.cmsmetaapi.meta_value[0].banner_image;
const facebookLink = getContactdata.cmsmetaapi.meta_value[0].facebook ;
const instagramLink = getContactdata.cmsmetaapi.meta_value[0].instagram ;
const twitterLink = getContactdata.cmsmetaapi.meta_value[0].twitter ;
    return (
        <>
            <section className='page-heading-main' style={{
              backgroundImage: `url(${(BannerImageUrl && BannerImageUrl)})`
            }}>
                <h1 className='text-center text-white'>{ getContactdata.title }</h1>
                <p className='text-center text-white m-0'>{sub_heading && sub_heading}</p>
            </section>
            <section className='contact-main'>
                <div className='container'>
                { succmessage ? <span className='succesmessage'>{succmessage}</span> : ""  } 
            <div class="row"><div class="col-md-5 col-sm-12 contact-information" style={{
              backgroundImage: `url(${(BannerImageUrl && BannerImageUrl)})`
            }}>
                            <h3 className='text-white'>{ contact_info }</h3>
                            <p className='text-white'>{ description }</p>
                            <ul className='list-unstyled ml-0 mb-0 p-0 company-info text-white'>
                                <li><FontAwesomeIcon icon={faPhone}></FontAwesomeIcon> {ph_info }</li>
                                <li><FontAwesomeIcon icon={faEnvelope}></FontAwesomeIcon> {email}</li>
                               
                            </ul>
							
                            {/* <ul className='list-unstyled p-0 ml-0 mb-0 d-inline-flex w-100 align-items-center social-list'>
                                <li className='m-0 mr-4'><a target="_blank" href={facebookLink}><img src={facebookLink && Fbicon} alt='' /></a></li>
                                <li className='m-0 mr-4'><a target="_blank" href={twitterLink ? twitterLink : 'Twitter'}><img src={twitterLink && Twittericon} alt='' /></a></li>
                                <li className='m-0 mr-4'><a target="_blank" href={instagramLink}><img src={instagramLink && Instaicon} alt='' /></a></li>
                            </ul> */}
                        </div>
        <div class="col-md-7 col-sm-12 contact-form">            
         
            <form id="create-course-form" className='d-flex justify-content-between flex-wrap'>
            <div className='form-group'>
                <label>First Name*</label>
                     <input type='text'  name='firstname' onChange={this.handleChange} noValidate />
                   <span className="errorstyle" style={{display:'none'}} id="firstname">Please enter First Name</span>
                   {errors.firstname.length > 0 &&  
                <span style={{color: "#ff0000b8"}} className='error'>{errors.firstname}</span>}

            </div>
             <div className='form-group'>
                    <label>Last Name*</label>
                    <input  type='text' name="lastname" onChange={this.handleChange}  />
                    <span style={{display:'none'}} className="errorstyle" id="lastname">Please enter required field</span>
                    {errors.lastname.length > 0 && <span style={{color: "#ff0000b8"}} className='error'>{errors.lastname}</span>}
            </div>
            <div className='form-group'>
                <label>Email Address*</label>
                <input  required type='email' name="email" onChange={this.handleChange} noValidate  />
                 <span className="errorstyle" style={{display:'none'}} id="email">Please enter required field</span>
                 {errors.email.length > 0 && <span style={{color: "#ff0000b8"}} className='error'>{errors.email}</span>}
            </div>    
            <div className='form-group'>
                <label>Phone Number*</label>
                <input  type='number' name="phone" onChange={this.handleChange} noValidate  />
                 <span className="errorstyle" style={{display:'none'}} id="phone">Please enter required field</span>
                {errors.phone.length > 0 && <span style={{color: "#ff0000b8"}} className='error'>{errors.phone}</span>}
            </div>
            <div className='form-group w-100'>
                <label>Message</label>
                 <span style={{display:'none'}} id="message">Please enter required field</span>
                <textarea  name="message" onChange={this.handleChange} noValidate ></textarea>
                {errors.message.length > 0 && <span style={{color: "#ff0000b8"}} className='error'>{errors.message}</span>}
            </div>
            <div className='form-group w-100 m-0 d-inline-flex justify-content-end'>
            <button  className='btn btn-common btn-green'  onClick={ (e) => { this.handleSubmit(e) }}>

  {this.state.loading ? "Sending..." : "Send Message"}
            </button> 
            </div>
            </form>
            </div>
        </div>
                </div>
            </section>
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
function ValidateEmail(mail) 
{
 if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail))
  {
    return true
  }
    return false
}


export default withRouter(Contact);