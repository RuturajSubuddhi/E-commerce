import React from 'react'
import AppRoutes from './routes/AppRoutes'
import Header from './components/layout/Header'
import Footer from './components/layout/Footer'
import { ToastContainer } from "react-toastify";


export default function App() {
  return (
    <div className="min-h-screen flex flex-col">
      <Header />
      <main className="flex-1 container-fluid mx-auto px-0 py-6">
        <AppRoutes />
      </main>
      <Footer />
      <ToastContainer position="top-right" />

    </div>
  )
}
