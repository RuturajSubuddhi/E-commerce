// import React from 'react'
// import ProductCard from './ProductCard'
// import { sampleProducts } from '../../constants/sampleData'

// export default function ProductList() {
//   return (
//     <div className="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
//       {sampleProducts.map(p => (
//         <ProductCard key={p.id} product={p} />
//       ))}
//     </div>
//   )
// }

import React, { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";

const ProductList = ({ products }) => {
    const [visibleCount, setVisibleCount] = useState(4); // initially show 4 products

    const handleLoadMore = () => {
        setVisibleCount((prev) => prev + 4); // load 4 more each time
    };

    return (
        <div className="text-center py-10 bg-black text-white">
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-6">
                <AnimatePresence>
                    {products.slice(0, visibleCount).map((product, index) => (
                        <motion.div
                            key={product.id}
                            className="bg-gray-900 p-4 rounded-xl shadow-md hover:shadow-lg transition-all"
                            initial={{ opacity: 0, y: 40 }}
                            animate={{ opacity: 1, y: 0 }}
                            exit={{ opacity: 0, y: -40 }}
                            transition={{ duration: 0.4, delay: index * 0.05 }}
                        >
                            <img
                                src={product.image}
                                alt={product.name}
                                className="w-full h-48 object-cover rounded-lg"
                            />
                            <h3 className="mt-3 font-semibold text-lg">{product.name}</h3>
                            <p className="text-red-400 font-bold mt-2">
                                Rs. {product.price.toLocaleString()}
                            </p>
                            <p className="text-sm text-gray-400 line-through">
                                Rs. {product.originalPrice.toLocaleString()}
                            </p>
                            <p className="text-yellow-400 text-xs mt-1">Low stock</p>
                        </motion.div>
                    ))}
                </AnimatePresence>
            </div>

            {/* Load More Button */}
            {visibleCount < products.length && (
                <motion.button
                    onClick={handleLoadMore}
                    className="mt-8 bg-white text-black px-6 py-2 rounded-lg font-semibold hover:bg-gray-200 transition-all"
                    whileHover={{ scale: 1.05 }}
                    whileTap={{ scale: 0.95 }}
                >
                    Load More
                </motion.button>
            )}
        </div>
    );
};

export default ProductList;

