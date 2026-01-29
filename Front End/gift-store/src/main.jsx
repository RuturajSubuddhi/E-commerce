import React from 'react'
import { createRoot } from 'react-dom/client'
import { BrowserRouter } from 'react-router-dom'
import App from './App'
// import './styles/tailwind.css'
// import './index.css'
import 'bootstrap/dist/css/bootstrap.min.css';
import { CartProvider } from "./context/CartContext";
import {WishlistProvider} from "./context/WishlistContext";


// import { CartProvider } from './context/CartContext'

createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <BrowserRouter>
      <CartProvider>
        <WishlistProvider>
        <App />
      </WishlistProvider>
      </CartProvider> 
    </BrowserRouter>
  </React.StrictMode>
)
