import React, { Component, useEffect } from 'react';
import '../Main.css';
import Cookies from 'universal-cookie';
import Logo from '../images/logo.png';
import { Route, Link, BrowserRouter as Router, Switch, withRouter } from 'react-router-dom';
import axios from "../axios";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faShoppingCart, faUser } from "@fortawesome/free-solid-svg-icons";
import { instanceOf } from 'prop-types';
const cookies = new Cookies();

if (typeof cookies.get('user') !== 'undefined') {
    var getcookie = cookies.get('user');
}
else {
    var getcookie = { user: "logout", user_data: "johnDoe" };
}
class Header extends Component {
    constructor(props) {
        super(props)
        this.state = {
            username: getcookie,
            isLogin: false,
            userName: ''
        }

    }
    componentDidMount() {
        this.interval = setInterval(() => {
            if (typeof cookies.get('user') !== 'undefined') {
                getcookie = cookies.get('user');
            }
            else {
                getcookie = { user: "logout", user_data: "johnDoe" };
            }
            this.setState({ username: getcookie });
            if (this.state.username.user == "loggedIn") {
                this.setState({ isLogin: true, userName: this.state.username.user_data });
            }
            else {
                this.setState({ isLogin: false });
            }

        }, 2000);
        this.setState({ username: getcookie });
        if (this.state.username.user == "loggedIn") {
            this.setState({ isLogin: true, userName: this.state.username.user_data });
        }
        else {
            this.setState({ isLogin: false });
        }



    }

    componentWillUnmount() {
        if (this.state.isLogin) {
            clearInterval(this.interval);
        }

    }
    render() {
        const { isLogin, userName } = this.state;
        return (
            <header className='header' id='myheader'>
                <div className='container'>
                    <div class="row justify-content-between align-items-center">
                        <div className='logo'>
                            <Link to="/"><img src={Logo} alt='' /></Link>
                        </div>
                        <div className='main-nav' id='main-nav'>
                            {this.state.isLogin ?
                                <ul id='loggein' className='list-unstyled d-flex align-items-center m-0' >
                                    
                                    <li><a href="/services">Services</a>
                                        <ul className="sub-menu">
                                             <li> <a href="/services/embroidery-digitizing">Embroidery Digitizing</a></li>
                                            <li><a href="/services/logo-digitizing">Logo Digitizing</a></li>
                                            <li><a href="/services/custom-digitizing">Custom Digitizing</a></li>
                                            <li><a href="/services/left-chest-digitizing">Left Chest Digitizing</a></li>
                                            <li><a href="/services/jacket-back-digitizing">Jacket Back Digitizing</a></li>
                                            <li><a href="/services/applique-digitizing">Applique Digitizing</a></li>
                                            <li><a href="/services/wholesale-digitizing">Wholesale Digitizing</a></li>
                                            <li><a href="/services/hand-drawn-logo-digitizing">Hand Drawn Logo Digitizing</a></li>
                                            <li><a href="/services/image-digitizing">Image Digitizing</a></li>
                                            <li><a href="/services/photo-digitizing">Photo Digitizing</a></li>
                                            <li><a href="/services/3d-puff-embroidery-digitizing">3d Puff Embroidery Digitizing</a></li>
                                            
                                             
                                        </ul>
                                    </li>
                                    <li><a href="tel:18447862459">1-844-PUNCHLY (786-2459)</a></li>
                                    <li className="cart-nav"><Link to="/backend/embroiderer/cart"><FontAwesomeIcon icon={faShoppingCart}></FontAwesomeIcon></Link></li>
                                    <li><Link className='btn btn-common btn-green' to="/backend/admin/dashboard"><FontAwesomeIcon icon={faUser}></FontAwesomeIcon> {this.state.userName}</Link></li>
                                </ul> :
                                <ul id='loggedout' className='list-unstyled d-flex align-items-center m-0'>
                                     
                                    <li><a href="/services">Services</a>
                                        <ul className="sub-menu">
                                            <li> <a href="/services/embroidery-digitizing">Embroidery Digitizing</a></li>
                                            <li><a href="/services/logo-digitizing">Logo Digitizing</a></li>
                                            <li><a href="/services/custom-digitizing">Custom Digitizing</a></li>
                                            <li><a href="/services/left-chest-digitizing">Left Chest Digitizing</a></li>
                                            <li><a href="/services/jacket-back-digitizing">Jacket Back Digitizing</a></li>
                                            <li><a href="/services/applique-digitizing">Applique Digitizing</a></li>
                                            <li><a href="/services/wholesale-digitizing">Wholesale Digitizing</a></li>
                                            <li><a href="/services/hand-drawn-logo-digitizing">Hand Drawn Logo Digitizing</a></li>
                                            <li><a href="/services/image-digitizing">Image Digitizing</a></li>
                                            <li><a href="/services/photo-digitizing">Photo Digitizing</a></li>
                                            <li><a href="/services/3d-puff-embroidery-digitizing">3d Puff Embroidery Digitizing</a></li>
                                            
                                          
                                        </ul>
                                    </li>
                                    <li><a href="tel:18447862459">1-844-PUNCHLY (786-2459)</a></li>
                                    <li className='mr-2 btn btn-common btn-gray'><Link   to="/backend/login">Login</Link>/<Link  to="/backend/register">Sign up</Link></li>
                                     
                                </ul>
                            }

                        </div>
                    </div>
                </div>
            </header>
        );
    }
}
export default Header;