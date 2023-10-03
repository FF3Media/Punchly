import React ,{Component} from 'react';
import { withRouter } from 'react-router-dom';
import axios from "../axios";
import Loading from "react-loader-spinner";
import { Helmet } from 'react-helmet';
import MetaTags from 'react-meta-tags';
class ReturnPolicy extends Component {
      constructor () {
        super()
        this.state = {
         getreturnData: {},
           loading: true
        }
      }
componentDidMount () { 
axios.get('/cms/cms-meta/5/').then(response => {
        this.setState({getreturnData : response.data.data, loading : false })
}).catch(err => {
    console.log("ERROR: " + err);
 });
 window.scrollTo(0, 0)
}
 render () {
    const { getreturnData, loading } = this.state;
    const style = {textAlign: 'center',height: 600, flex: 1,marginTop:240, flex: 1,justifyContent: 'center',alignItems:'center'};  
    if(Object.keys(getreturnData).length === 0) {
    return <div style={style}>
          <Loading 
        type="Puff"
        color="#2BC0BA"
        height={70}
        width={70}
        timeout={2000} //3 secs
      /></div>;

  }
const Titletop = getreturnData.title
const  Meta_tag =  getreturnData.meta_tag;
 const  Meta_description =  getreturnData.meta_description;
const title = getreturnData.cmsmetaapi.meta_value[0].title
const updatedAt = getreturnData.updated_at;
const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const now = new Date(updatedAt);
const posted_date = (months[now.getMonth()] + ' ' + now.getDate() + ', ' + now.getFullYear());
const pageContent =  getreturnData.cmsmetaapi.meta_value[0].content;
const BannerImageUrl =  getreturnData.home_path+'/'+getreturnData.cmsmetaapi.meta_value[0].banner_image; 
    return (
        <>
        <div>
           <Helmet>
            <title>{Titletop}</title>
            </Helmet>

        </div>  
        <MetaTags> 
            <meta id="meta-description" name="description" content={Meta_description} /> 
            <title>{Titletop}</title>         
            <meta id="og-title" property="og:title" content={Titletop} /> 
            <meta name="keywords" content={Meta_tag} />      
            <meta id="og-image" property="og:image" content={BannerImageUrl} />
           </MetaTags> 
         <section className='page-heading-main' style={{
              backgroundImage: `url(${(BannerImageUrl && BannerImageUrl)})`
            }}>
                <h1 className='text-center text-white'>{ title }</h1>
                 

            </section>
           <section className='terms-privacy'>
            <div className='container'>
            <div className='row'>
            <div className='col-lg-12 col-sm-12'  dangerouslySetInnerHTML={{__html: pageContent}} />

            </div>
            </div>
         </section>
        </>
    );
}
}
export default withRouter(ReturnPolicy);