import React, { Component } from 'react';
// import ReactDOM from 'react-dom';

import Product from './Product.js';
import AddProduct from './AddProduct.js';

 
/* Main Component */
class ProductTest extends Component {
 
  constructor() {
   
    super();
    //Initialize the state in the constructor
    this.state = {
        products: [],

        currentProduct: null
    }

    this.handleAddProduct = this.handleAddProduct.bind(this);
  }
  /*componentDidMount() is a lifecycle method
   * that gets called after the component is rendered
   */
  componentDidMount() {
    /* fetch API in action */
    fetch('/api/products')
        .then(response => {
            return response.json();
        })
        .then(products => {
            //Fetched product is stored in the state
            this.setState({ products });
        });
  }
 
  renderProducts() {
    return this.state.products.map(product => {
        return (
            /* When using list you need to specify a key
             * attribute that is unique for each list item
            */
            
            /*<li key={product.id} >
                <h2>{ product.title }</h2>
            </li>      */


            //this.handleClick() method is invoked onClick.
            <li onClick={
                () =>this.handleClick(product)} key={product.id} >
                { product.title } 
            </li>  


        );
    })
  }

  handleClick(product) {
    //handleClick is used to set the state
    this.setState({currentProduct:product});  
  }




  handleAddProduct(product) {
     
   product.price = Number(product.price);
   /*Fetch API for post request */
   fetch( 'api/products/', {
       method:'post',
       /* headers are important*/
       headers: {
         'Accept': 'application/json',
         'Content-Type': 'application/json'
       },
        
       body: JSON.stringify(product)
   })
   .then(response => {
       return response.json();
   })
   .then( data => {
       //update the state of products and currentProduct
       this.setState((prevState)=> ({
           products: prevState.products.concat(data),
           currentProduct : data
       }))
   })
  }


  // logic for deleting a product
  handleDelete() {
    
	  const currentProduct = this.state.currentProduct;
	  fetch( 'api/products/' + this.state.currentProduct.id, 
	      { method: 'delete' })
	      .then(response => {
	        /* Duplicate the array and filter out the item to be deleted */
	        var array = this.state.products.filter(function(item) {
	        return item !== currentProduct
	      });
	    
	      this.setState({ products: array, currentProduct: null});
	 
	  });
	}


	// logic for updating a product
	handleUpdate(product) {
 
    const currentProduct = this.state.currentProduct;
    fetch( 'api/products/' + currentProduct.id, {
        method:'put',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(product)
    })
    .then(response => {
        return response.json();
    })
    .then( data => {
        /* Updating the state */
        var array = this.state.products.filter(function(item) {
          return item !== currentProduct
      })
        this.setState((prevState)=> ({
            products: array.concat(product),
            currentProduct : product
        }))
    }) 
  }

  

   
  render() {
   /* Some css code has been removed for brevity */
    return (
        <div>

              <div className="row">
              
                <div className="col-sm-12">
              		<AddProduct onAdd={this.handleAddProduct} />
                </div>

                <div className="col-sm-3 sidebar" style={{float: 'left'}}>
                  <h3> All products </h3>
                  <ul>
                    { this.renderProducts() }
                  </ul> 
                </div> 
               
               	<div className="col-sm-9 product">
                	<Product product={this.state.currentProduct} />
                </div>
              </div>

        </div>
    );
  }
}
 
export default ProductTest;
 
/* The if statement is required so as to Render the component on pages that have a div with an ID of "root";  
*/