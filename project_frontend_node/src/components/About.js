import React, { Component} from 'react';
import { withRouter } from 'react-router-dom';
import axios from "../axios";
import Loading from "react-loader-spinner";
import { Helmet } from 'react-helmet';
import MetaTags from 'react-meta-tags';
class About extends Component {
      constructor () {
        super()
        this.state = {
          getAboutata: {},
           loading: true
        }
      }
componentDidMount () { 
axios.get('/cms/cms-meta/3/').then(response => {
        this.setState({getAboutata : response.data.data, loading:false })
}).catch(err => {
    console.log("ERROR: " + err);
 });
 window.scrollTo(0, 0)
}
 render () {
    const {getAboutata} = this.state;
    const style = {textAlign: 'center',height: 600, flex: 1,marginTop:240, flex: 1,justifyContent: 'center',alignItems:'center'};  
    if(Object.keys(getAboutata).length === 0) {
    return <div style={style}><Loading
        type="Puff"
        color="#00BFFF"
        height={100}
        width={100}
        timeout={3000} 
      /></div>;

  }
    console.log(getAboutata.cmsmetaapi.meta_value);
    const Title = getAboutata.title;
    const  Meta_tag =  getAboutata.meta_tag;
    const  Meta_description =  getAboutata.meta_description;
    const main_title = getAboutata.cmsmetaapi.meta_value[0].title;
    const description = getAboutata.cmsmetaapi.meta_value[0].description;
    const  rightImage =  getAboutata.home_path+'/'+getAboutata.cmsmetaapi.meta_value[0].right_image;
    const  leftcontent =  getAboutata.cmsmetaapi.meta_value[0].leftcontent;
    const  alttag =  getAboutata.cmsmetaapi.meta_value[0].Alt_right_image_tag;
    const  videoUrl =  getAboutata.cmsmetaapi.meta_value[0].video_url;
    //console.log("ddddd",getAboutata.cmsmetaapi.meta_value[0].video_url)
    const BannerImageUrl =  getAboutata.home_path+'/'+getAboutata.cmsmetaapi.meta_value[0].banner_image;  
    return (
        <>
        <div>
      <Helmet>
        <title>{Title}</title>
      </Helmet>
      <MetaTags> 
            <meta id="meta-description" name="description" content={Meta_description} /> 
            <title>{Title}</title>         
            <meta id="og-title" property="og:title" content={Title} /> 
            <meta name="keywords" content={Meta_tag} />      
            <meta id="og-image" property="og:image" content={BannerImageUrl} />
           </MetaTags> 
        </div>
        <section className='page-heading-main' style={{
              backgroundImage: `url(${(BannerImageUrl && BannerImageUrl)})`
            }}>
                <h1 className='text-center text-white'>{Title}</h1> 

            </section>
        <section className='about-content'>
                <div className='container'>
                    <div className='row'>
                    <div className="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center shadow-bg-change text-center">
            <div className="embed-responsive embed-responsive-16by9" style={{ maxWidth: '850px'}}>
                            {/* <img className='img-fluid' src={rightImage && rightImage} alt={alttag} /> */}
                         <iframe className='embed-responsive-item' width="80%" height="400" src={videoUrl} title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        </div>
                       </div>
                       <div className='row align-items-center justify-content-center mt-5 '>
                        <div className='col-xl-8' dangerouslySetInnerHTML={{__html: leftcontent}} />
                       </div>
                     
                </div>
            </section>
            {/* <section className='page-heading-main' style={{
              backgroundImage: `url(${(BannerImageUrl && BannerImageUrl)})`
            }}>
                <h1 className='text-center text-white'>{main_title}</h1>
                <p className='text-center text-white m-0' dangerouslySetInnerHTML={{__html: description}} />
            </section> */}
          
        </>
    );
}
}

export default withRouter(About);