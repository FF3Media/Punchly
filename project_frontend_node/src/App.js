import './App.css';
import Header from './components/Header';
import Footer from './components/Footer';
import HomePage from './components/HomePage';
import Contact from './components/Contact';
import Blog from './components/Blog';
import Services from './components/Services';
import About from './components/About';
import BlogDetail from './components/BlogDetail';
import ServiceDetail from './components/ServiceDetail';
import ServiceHome from './components/ServiceHome';
import ReturnPolicy from './components/ReturnPolicy';
import TermsConditions from './components/TermsConditions';
import PrivacyPolicy from './components/PrivacyPolicy';
import MessengerCustomerChat from 'react-messenger-customer-chat';
import { Route, Link, BrowserRouter as Router, Switch, withRouter } from 'react-router-dom';
function App() {
  return (
    <div className="wrapper">
      <Router>
          <Header />
          <Switch> 
              <Route exact path="/" component={withRouter(HomePage)} />
              <Route exact path="/contact-us" component={withRouter(Contact)} />
              <Route exact path="/blog" component={withRouter(Blog)} />
              <Route exact path="/services" component={withRouter(Services)} />   
              <Route exact path="/services" component={withRouter(Footer)} />      
              <Route exact path="/blog/:id" component={withRouter(BlogDetail)} />
              <Route exact path="/services/:id" component={withRouter(ServiceDetail)} />
              <Route exact path="/embroidery-digitizing" component={withRouter(ServiceHome)} />          
              <Route exact path="/about" component={withRouter(About)} />
               <Route exact path="/privacy-policy" component={withRouter(PrivacyPolicy)} />
              <Route exact path="/refund-policy" component={withRouter(ReturnPolicy)} />
              <Route exact path="/terms-of-sale" component={withRouter(TermsConditions)} />
              
            <Route path='/backend/admin/dashboard' component={() => { 
                 window.location.href = 'https://punchly.io/backend/admin/dashboard'; 
            }}/>
            <Route path='/backend/embroiderer/cart' component={() => { 
                 window.location.href = 'https://punchly.io/backend/embroiderer/cart'; 
            }}/>
           
            <Route path='/backend/login' component={() => { 
                 window.location.href = 'https://punchly.io/backend/login'; 
            }}/>
            <Route path='/backend/register' component={() => { 
                 window.location.href = 'https://punchly.io/backend/register'; 
            }}/>
             

          </Switch>
          <Footer />
          <MessengerCustomerChat
            pageId="110166424481007"
            appId="301172744685648"
            
          />
      </Router>
    </div>
  );
}

export default App;
