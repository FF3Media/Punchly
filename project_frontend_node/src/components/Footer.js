import React ,{Component} from 'react';
import { Link, Redirect, useHistory  } from 'react-router-dom';
import Logo from '../images/logo.png';
import Fbicon from '../images/fb-icon.png';
import Twittericon from '../images/twitter.png';
import Instaicon from '../images/instagram.png';
import Paypalimg from '../images/paypal.png';
import Visaimg from '../images/visa.png';
import Mastercardimg from '../images/mastercard.png';
import Americanimg from '../images/american.png';
import Secureimg from '../images/secure-icon-footer.png';
import Loading from "react-loader-spinner";
import { faHome  } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import axios from "../axios";

class Footer extends Component {
      constructor (props) {
        super(props)
        this.state = {
         getreturnData: {},
           loading: true,
           getServiceData:{},
           redirect:false, 
           slug:''
        }
      }
      showAlert() {
       
             var someimage = document.getElementById('siteseal');
             var myimg = someimage.getElementsByTagName('img')[0];
             myimg.click();
      
    }
componentDidMount () {
this.setState({ loading: true }, () => {
axios.get('/cms/cms-meta/2/').then(response => {
        this.setState({ getContactdata : response.data.data, loading : false }, () => {});
}).catch(err => {
    console.log("ERROR: " + err);
 });
});

axios.get('/cms/services/')
      .then(response => 
     this.setState({ getServiceData : response.data.data ,loading: false }));

   


  }
handleClick(slug, e){  
    var link = '/embroidery-digitizing/'+slug
    if(slug=='embroidery-digitizing'){
        link = '/embroidery-digitizing'
    } 
    window.location.href = link
 }

render () {
const { getContactdata, getServiceData,slug } = this.state;
if(typeof getContactdata == 'undefined' || typeof getServiceData == 'undefined' ||  Object.keys(getServiceData).length < 1) {
return '';
}
if (this.state.redirect) {
    return <Redirect push to = {`/service/${this.state.slug}`} />
} 
const facebookLink = getContactdata.cmsmetaapi.meta_value[0].facebook 
const instagramLink = getContactdata.cmsmetaapi.meta_value[0].instagram 
const twitterLink = getContactdata.cmsmetaapi.meta_value[0].twitter 
const currentYear = new Date().getFullYear();

console.log("getServiceDatagetServiceData", getServiceData)
    return (
        <footer>
            <div class="container">
                <div className="row">
                    <div class="col-md-3 col-sm-12 p-0">
                        <h4>Information</h4>
                        <ul className='list-unstyled p-0 m-0'>
                            <li><Link to="/about">About Us</Link></li>
                            <li><Link to="/blog">Blogs</Link></li>
                            <li><Link to="/contact-us/">Contact Us</Link></li>
                            <li><Link to="/privacy-policy/">Privacy Policy</Link></li>
                            <li><Link to="/terms-of-sale/">Terms of sale</Link></li>
                            <li><Link to="/refund-policy/">Refund policy</Link></li>
                          
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-12 p-0 pl-4">
                        <h4>Embroidery digitizing services</h4>
                       
                        <div className="d-flex flex-wrap">
                            <ul className='list-unstyled p-0 m-0 col-md-6 col-sm-12'>
                             { getServiceData.map((item,index) => (
                              index < 5 ? <li style={{cursor:'pointer'}} key={index}  onClick={()=>{this.handleClick(item.service_slug)}} >{item.service_title}</li>:""
                            )) }
                            </ul>
                            <ul className='list-unstyled p-0 m-0 col-md-6 col-sm-12'>
                            { getServiceData.map((item,index) => (
                              index >= 5 ? <li  style={{cursor:'pointer'}} key={index}  onClick={()=>{this.handleClick(item.service_slug)}} >{item.service_title}</li>:""
                            )) }
                            </ul>
                        </div>
                    </div>
                    <div className='col-md-3 col-sm-12 p-0'>
                        <ul className='list-unstyled p-0 m-0 d-inline-flex w-100 justify-content-end align-items-center social-list'>
                            <li className='m-0 mr-4'><a target="_blank" href={facebookLink}><img src={Fbicon} alt='' /></a></li>
                            <li className='m-0 mr-4'><a target="_blank" href={twitterLink ?twitterLink:'Twitter' }><img src={Twittericon} alt='' /></a></li>
                            <li className='m-0 mr-4'><a target="_blank" href={instagramLink ? instagramLink: 'twitter'}><img src={Instaicon} alt='' /></a></li>
                        </ul>
                    </div>

                    <div className='footer-bottom d-inline-flex w-100 align-items-center justify-content-between pt-4 mt-3'>
                        <div className='left-bottom d-inline-flex align-items-center'>
                            <Link to="/"><img src={Logo} alt='' /></Link>
                            
                            <p className='m-0 ml-4 pl-3'>© Punchly {currentYear}. All rights reserved.</p>
                             <img className='godadyimg' onClick={this.showAlert} src="https://punchly.myfileshosting.com/images/siteseal_gd_3_h_l_m.gif"   alt="SSL site seal - click to verify"/>

                        </div>
                        <div className='right-bottom'>
                            <ul className='d-inline-flex list-unstyled align-items'>
							<li className='mb-0 mr-3 secure-footer-img'><img src={Secureimg} alt='' /></li>
                                <li className='mb-0 mr-3'><img src={Paypalimg} alt='' /></li>
                                <li className='mb-0 mr-3'><img src={Visaimg} alt='' /></li>
                                <li className='mb-0 mr-3'><img src={Mastercardimg} alt='' /></li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    );
}
}
export default Footer;