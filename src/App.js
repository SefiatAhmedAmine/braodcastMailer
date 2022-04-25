import React from 'react'
import SideBar from './components/sidebar/SideBar'
import Courrier from './Courrier'

function App() {
  return (
    <>
      <nav className="navbar navbar-expand-sm bg-primary navbar-dark">
        <div className="container-fluid">
          <a className="navbar-brand" href=".">HOLDING AL OMRANE</a>          
        </div>
      </nav>
      
    <SideBar/>

    <div id=''></div>

    <Courrier/>

    </>
  )
}

export default App