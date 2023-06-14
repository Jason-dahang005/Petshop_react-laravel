import { useState } from 'react'

import {BrowserRouter, Routes, Route} from 'react-router-dom'
import Register from './pages/authentication/Register'
import Login from './pages/authentication/Login'
import Home from './pages/users/Home'

function App() {

  return (
    <BrowserRouter>
      <Routes>
        <Route path='/login' element={<Login/>} />
        <Route path='/register' element={<Register/>} />
        <Route path='/' element={<Home/>} />
      </Routes>
    </BrowserRouter>
  )
}

export default App
