import React from 'react'
import {Navigate } from 'react-router-dom'
import auth from '../services/auth'

export const ProtectedRoute = ({ children }) => {
  console.log(auth.isAuthenticated()); 
  if (auth.isAuthenticated()) {
    return children;
  }
  else {
    return <Navigate to="/" />
  }
    
}
