// import { Link } from 'react-router-dom';

// const ProductCard = ({ product }) => {
//   return (
//     <div className="product-card bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
//       <div className="relative">
//         <img 
//           src={product.image} 
//           alt={product.name}
//           className="w-full h-56 object-cover"
//         />
//         {product.isNew && (
//           <span className="absolute top-2 left-2 bg-purple-600 text-white text-xs px-2 py-1 rounded">
//             New
//           </span>
//         )}
//         {product.discount > 0 && (
//           <span className="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
//             -{product.discount}%
//           </span>
//         )}
//       </div>
      
//       <div className="p-4">
//         <h3 className="text-lg font-semibold text-gray-800 mb-1">{product.name}</h3>
//         <p className="text-gray-600 text-sm mb-3">{product.category}</p>
        
//         <div className="flex items-center justify-between">
//           <div>
//             {product.discount > 0 ? (
//               <div className="flex items-center">
//                 <span className="text-lg font-bold text-gray-800">${product.price - (product.price * product.discount / 100)}</span>
//                 <span className="text-sm text-gray-500 line-through ml-2">${product.price}</span>
//               </div>
//             ) : (
//               <span className="text-lg font-bold text-gray-800">${product.price}</span>
//             )}
//           </div>
          
//           <button className="bg-purple-600 text-white p-2 rounded-full hover:bg-purple-700 transition-colors">
//             <i className="fas fa-shopping-cart"></i>
//           </button>
//         </div>
//       </div>
//     </div>
//   );
// };

// export default ProductCard;