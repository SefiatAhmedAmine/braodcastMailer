import axios from 'axios';
import React from 'react'
import { HomeContent } from '../components/homeContent/HomeContent'
import SideBar from '../components/sidebar/SideBar'
import Courrier from '../Courrier'
import auth from '../services/auth';
import './home.css';


const Backend = 'http://courrier.back/backend/src/controllers/AuthController.php';

export const Home = () => {

  function deconnexion() {
    let data = {
      action:'logout',
      user: localStorage.getItem('user'),
      user_id: localStorage.getItem('user_id')
    }
    axios.post(Backend, data)
    .then(function(response) {
      console.log(response)
      if (response.data['status'] == true) {
        auth.logout();
        window.location = '/home';
      }
    })
    .catch(function(error) {
      console.error(error)
    })

  }

  return (
    <div className='background'>
      <nav className="navbar navbar-expand-sm bg-success navbar-dark sticky-top">
        <div className="container-fluid">
          <a className="navbar-brand" href=".">GROUPE AL OMRANE</a>
        </div>
        <button type="button" onClick={deconnexion} class="btn btn-danger float-end me-5">Deconnexion</button>
        
      </nav>

      <SideBar />

      <HomeContent />

      <Courrier />

    </div>
  )
}

