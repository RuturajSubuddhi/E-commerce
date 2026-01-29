// import React from 'react'
// import { useParams } from 'react-router-dom'
// import { sampleProducts } from '../constants/sampleData'
// import { useCart } from '../context/CartContext'

// export default function ProductPage() {
//   const { id } = useParams()
//   const product = sampleProducts.find(p => p.id === id) ?? sampleProducts[0]
//   const { addToCart } = useCart()

//   return (
//     <div className="grid md:grid-cols-2 gap-6">
//       <img src={product.image} alt={product.title} className="w-full rounded" />
//       <div>
//         <h1 className="text-2xl font-bold">{product.title}</h1>
//         <p className="mt-2 text-lg font-semibold">₹{product.price}</p>
//         <p className="mt-4">{product.description}</p>
//         <button
//           onClick={() => addToCart(product)}
//           className="mt-6 px-4 py-2 bg-indigo-600 text-white rounded"
//         >
//           Add to cart
//         </button>
//       </div>
//     </div>
//   )
// }
