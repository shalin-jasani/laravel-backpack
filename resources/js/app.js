import ReactDOM from "react-dom";
import React from "react";
import Example from "./components/Example";
import { Router, Route, browserHistory } from 'react-router';

import Master from './components/Master';
import CreateProduct from './components/CreateProduct';
import DisplayProduct from './components/DisplayProduct';
import UpdateProduct from './components/UpdateProduct';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');
/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if (document.getElementById('root')) {
  ReactDOM.render(
    <Router history={browserHistory}>
      <Route path="/" component={Master} >
        <Route path="/add-item" component={CreateProduct} />
        <Route path="/display-item" component={DisplayProduct} />
        <Route path="/edit/:id" component={UpdateProduct} />
      </Route>
    </Router>, document.getElementById('root'));
}