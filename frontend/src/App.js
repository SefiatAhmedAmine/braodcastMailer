import React from "react";
import {
  Routes,
  Route,
} from "react-router-dom";
import { ProtectedRoute } from "./components/ProtectedRoute";
import { Home } from "./pages/Home";
import { Login } from "./pages/Login";


function App() {
  return (

    <Routes>

      <Route path="/" element={<Login />} />

      <Route axact path="/home" element={
        <ProtectedRoute>
          <Home />
        </ProtectedRoute>
      } 
      />

      <Route path="*" component={() => "404 NOT FOUND"} />

    </Routes>

  );
}

export default App;