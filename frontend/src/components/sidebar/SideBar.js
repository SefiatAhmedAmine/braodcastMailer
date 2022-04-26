import './sidebar.css'

import React, { useState } from 'react'

function SideBar() {
  const [navOpened, setNavOpened] = useState(false);
  const openNav = () => {
    document.getElementById("mySidebar").style.width = "fit-content";
    document.getElementById('mySideBar-content').style.display="block"
    // document.getElementById("main").style.marginLeft = "250px";
  }

  const closeNav = () => {
    document.getElementById("mySidebar").style.width = "50px";
    document.getElementById('mySideBar-content').style.display="none"
    // document.getElementById("main").style.marginLeft= "30px";
  }

  const handleSideBar = () => {
    if (navOpened === false) {
      openNav();
      setNavOpened(true);
    }
    else {
      closeNav();
      setNavOpened(false);
    }
  }
  return (
    <div id="mySidebar" className="sidebar sticky">
      <button className="openbtn" onClick={handleSideBar}>☰</button>
      <div id='mySideBar-content' className='sidebar-content'>
      {/* Button to Open the Modal  */}
        <button type="button" className="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Nouveau message
        </button>
        {/* <a href="#">Link</a> */}
        
      </div>
    </div>
  )
}

export default SideBar