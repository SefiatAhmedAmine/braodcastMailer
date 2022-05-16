import axios from 'axios';
import React, { useState } from 'react'
import {Navigate} from 'react-router-dom'
import auth from '../services/auth';
const Backend = 'http://courrier.back/backend/src/controllers/AuthController.php';


export const Login = props => {

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const authenticate = () => {
    let $data = {
      email:email,
      password: password,
      action: "login"  
    };

    axios.post(Backend, $data)
    .then(function(response){
      console.log(response);
      if (response.data["status"] == true){
        auth.login(response.data["user"], response.data['user_id'])
        window.location='/home';
      }
    })
    .catch(function (error){
      console.error(error)
    })
  }

  return (
    <div className='mt-5'>
      <div className="container">
        <div id="login-row" className="row justify-content-center align-items-center">
          <div id="login-column" className="col-md-6">
            <div id="login-box" className="col-md-12">
              <form id="login-form" className="form">
                <h3 className="text-center text-info">Login</h3>
                <div className="form-group">
                  <label htmlFor="username" className="text-info">Email:</label><br />
                  <input type="text" name="username" id="username" className="form-control"
                    onChange={(e)=> {setEmail(e.target.value)}} />
                </div>
                <div className="form-group">
                  <label htmlFor="password" className="text-info">Password:</label><br />
                  <input type="text" name="password" id="password" className="form-control" 
                    onChange={(e)=>{setPassword(e.target.value)}}/>
                </div>
                <br />
                <div className="form-group">
                  <input type="button" name="submit" className="btn btn-info btn-md" value="submit"
                    onClick={authenticate} />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
