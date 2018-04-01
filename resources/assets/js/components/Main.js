import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import ProductTest from './ProductTest.js';

import { BrowserRouter as Router, Route, Link } from 'react-router-dom'

// Layouts
import Navbar from './templates/Layouts/Navbar.js';

import Dashboard from './templates/Dashboard/index.js';
import Outputs from './templates/Outputs/index.js';
import Outcomes from './templates/Outcomes/index.js';


 
/* Main Component */
class Main extends Component {
   
  render() {
    // const site_url = '/';
    const site_url = '/main/';

    return (
      <Router>
        <div>
            <Navbar />


            <div className="content">
              <div className="container-fluid">

              <Route exact path={site_url + 'producttest'} component={ProductTest}/>


              <Route exact path={site_url} component={Dashboard}/>
              <Route exact path={site_url + 'outputs'} component={Outputs}/>
              <Route exact path={site_url + 'outcomes'} component={Outcomes}/>

              </div>
            </div>

            <Footer />
        </div>
      </Router>
    );
  }
}
 
export default Main;
 
/* The if statement is required so as to Render the component on pages that have a div with an ID of "root";  
*/
 
if (document.getElementById('root')) {
    ReactDOM.render(<Main />, document.getElementById('root'));
}