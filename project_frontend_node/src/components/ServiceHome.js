import React ,{Component} from 'react';
import { withRouter } from 'react-router-dom';
import { Link } from 'react-router-dom';
import axios from "../axios";
import Loading from "react-loader-spinner";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faCalendarCheck} from "@fortawesome/free-regular-svg-icons";
import {faAngleRight, faAngleLeft} from "@fortawesome/free-solid-svg-icons";
import MetaTags from 'react-meta-tags';
import { Helmet } from "react-helmet";
class ServiceHome extends Component {
      constructor (props) {
        super(props)
        this.state = {
          getService: {},
          loading :false,
           email: '',
            errors: {
                email: ''
              }
        }


      }

componentDidMount () {
  this.setState({ loading: true }, () => {
    // const slug = this.props.match.params.id;
axios.get('/cms/service/embroidery-digitizing').then(response => {

          this.setState({
            getService: response.data.data[0],
            loading:false
          });
        });
});
window.scrollTo(0, 0)
}

render () {
    const {getService, loading}  = this.state;
      console.log("getService55",getService.meta_description)
    const style = {textAlign: 'center',height: 600, flex: 1,marginTop:240, flex: 1,justifyContent: 'center',alignItems:'center'};  
     if(typeof getService == 'undefined' || Object.keys(getService).length < 1 ){
        return <div style={style}><Loading
        type="Puff"
        color="#00BFFF"
        height={100}
        width={100}
        timeout={3000} 
      /></div>;
     }
   
    const  getServiceDescription =  getService.service_description; 
    return (
  <>
    
          <MetaTags>
             
            <meta id="meta-description" name="description" content={getService.meta_description} /> 
            <title>{getService.meta_title}</title>         
            <meta id="og-title" property="og:title" content={getService.service_title} /> 
            <meta name="keywords" content={getService.meta_tag} />      
            <meta id="og-image" property="og:image" content={getService.feature_image} />
            
          </MetaTags>

     
      
        <section className='blog-detail-banner'
        style={{
          backgroundImage: `url('${(getService.feature_image && getService.feature_image)}')`
        }}>
         </section>                   
             <section className='blog-detail-content m-auto'>
                <div className='container mt-4 pt-3'>
                    <div className='row'>
                        <div className='col-md-12 p-0 inner-container'>                  
                            <h1>{getService.service_title}</h1>                         
                            <div dangerouslySetInnerHTML={{__html: getServiceDescription}} />
                            <div className="btnseting">
                              <a className='btn btn-common digitize-btn' href="/backend/embroiderer/createNew" >
                                Digitize Now
                              </a>
                            </div>
                            </div>
                    </div>
                </div>
            </section>
       
        
        </>
    );
}
}

export default withRouter(ServiceHome);