import React, { Component } from 'react';
import { BrowserRouter as Router, Route, Link } from 'react-router-dom'

class Navbar extends Component {
	render() {
    // const site_url = '/';
    const site_url = '/main/';
    
    return (    	
        <nav className="navbar navbar-expand-lg navbar-light bg-light">
          <Link to={site_url} className="navbar-brand">Unicef</Link>

          <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span className="navbar-toggler-icon"></span>
          </button>

          <div className="collapse navbar-collapse" id="navbarSupportedContent">
            <ul className="navbar-nav mr-auto">
              <li className="nav-item active">
                <Link className="nav-link" to={site_url}>Home <span className="sr-only">(current)</span></Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to={site_url + 'outputs'}>Outputs</Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to={site_url + 'outcomes'}>Outcomes</Link>
              </li>

              
              <li className="nav-item hidden-xs-up hidden">
                <Link className="nav-link" to={site_url + 'producttest'}>ProductTest</Link>
              </li>

            </ul>
          </div>
        </nav>
  	);
  }
}
export default Navbar;