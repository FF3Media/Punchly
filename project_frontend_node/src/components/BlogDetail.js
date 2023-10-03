import React ,{Component} from 'react';
import { withRouter } from 'react-router-dom';
import { Link } from 'react-router-dom';
import axios from "../axios";
import Loading from "react-loader-spinner";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faCalendarCheck} from "@fortawesome/free-regular-svg-icons";
import {faAngleRight, faAngleLeft} from "@fortawesome/free-solid-svg-icons";
class BlogDetail extends Component {
      constructor (props) {
        super(props)
        this.state = {
          blogsDetail: {},
          getHomedata: {},
          getBlogdata: {},
          showNextButton : true,
          loading :true,
           email: '',
            errors: {
                email: ''
              }
        }
      }
componentDidMount () {
    this.setState({ loading: true }, () => {
      const id = this.props.match.params.id
        axios.get('/cms/blog-single/'+id).then(response => {
          this.setState({
            blogsDetail: response.data.data,
            loading:false
          });
        });
        axios.get('/cms/cms-meta/1/').then(response => {
        this.setState({getHomedata : response.data.data })
            }).catch(err => {
                console.log("ERROR: " + err);
        });
});
}

handleNext = (id,e) => {
axios.get('/cms/blog/')
      .then(response => this.setState({
        getBlogdata : response.data.data
      } , ()=> {
    const { getBlogdata } = this.state;
    const post_id = this.props.match.params.id;   
     const index = this.state.getBlogdata.findIndex((element, index) => {
        const sizeOfBlogs = this.state.getBlogdata.length;
        if (element.id === id) { 
            index = index + 1; 
              if(sizeOfBlogs > index) {
                this.setState({blogsDetail : getBlogdata[index], showNextButton : true } , () => { });
              }
              else {
              this.setState({showNextButton : false })          
            }
          }
        })
    }));
}

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
              this.setState({loading: false})
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
    const {blogsDetail, getHomedata,errors, succmessage, showNextButton, loading} = this.state;
    const style = {textAlign: 'center',height: 600, flex: 1,marginTop:240, flex: 1,justifyContent: 'center',alignItems:'center'};  
     if(typeof blogsDetail == 'undefined' || Object.keys(blogsDetail).length < 1 || typeof getHomedata == 'undefined' || Object.keys(getHomedata).length < 1){
        return <div style={style}><Loading
        type="Puff"
        color="#00BFFF"
        height={100}
        width={100}
        timeout={3000} 
      /></div>;
     }
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const now = new Date(blogsDetail.created_at);
    const posted_date = (months[now.getMonth()] + ' ' + now.getDate() + ', ' + now.getFullYear());
    const  SectionSubscription =  getHomedata.cmsmetaapi.meta_value[0].section_seven_description;            
    const  SectionSubbackImage =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_seven_image;
    const  SectionEightDescription =  getHomedata.cmsmetaapi.meta_value[0].section_eight_description;            
    const  SectionEightImage =  getHomedata.home_path+'/'+getHomedata.cmsmetaapi.meta_value[0].section_eight_image; 
    const  blog_description =  blogsDetail.blog_description; 
    return (
        <>
        <section className='blog-detail-banner'
        style={{
          backgroundImage: `url("${(blogsDetail.feature_image && blogsDetail.feature_image)}")`
        }}>
         
            </section>                    
                <section className='back-next-nav m-auto'>
                <div className='container mt-4 pt-3'>
                    <div className='row'>
                        <div class="col-md-6 col-sm-12 p-0">
                            <Link className='d-inline-flex align-items-center' to='/blog'><span><FontAwesomeIcon icon={faAngleLeft}></FontAwesomeIcon></span> Back to Punchly Blog</Link>
                        </div>
                        <div class="col-md-6 col-sm-12 d-flex justify-content-end p-0">                         
                            { showNextButton && <a href={void(0)}className='d-inline-flex align-items-center' onClick={()=>{this.handleNext(blogsDetail.id)}} >Next article <span className='next-article'><FontAwesomeIcon icon={faAngleRight}></FontAwesomeIcon></span></a>}
                        </div>
                    </div>
                </div>
            </section>
          
             <section className='blog-detail-content m-auto'>
                <div className='container mt-4 pt-3'>
                    <div className='row'>
                        <div className='col-md-12 p-0 inner-container'>
                        <p className='category-tag purple-bg text-center'><span>{!!(blogsDetail.blog_cat.name)?blogsDetail.blog_cat.name:""}</span></p>
                            <h1>{blogsDetail.blog_title}</h1>
                            <span className='date-item text-center mt-4 d-block'><FontAwesomeIcon icon={faCalendarCheck}></FontAwesomeIcon> {posted_date}</span>
                            <div dangerouslySetInnerHTML={{__html: blog_description}} />
                            </div>
                    </div>
                </div>
            </section>
            <section className='subscribe subscribe-inner-pages' style={{
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
export default withRouter(BlogDetail);