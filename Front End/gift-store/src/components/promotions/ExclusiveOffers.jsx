// import { useState, useEffect } from 'react';
// import { Link } from 'react-router-dom';

// const ExclusiveOffers = () => {
//   const [offers, setOffers] = useState([]);
//   const [timeRemaining, setTimeRemaining] = useState({
//     days: 0,
//     hours: 0,
//     minutes: 0,
//     seconds: 0
//   });

//   useEffect(() => {
//     // Simulate API call to fetch exclusive offers
//     setOffers([
//       {
//         id: 1,
//         title: "Summer Special",
//         description: "Get 25% off on all beach-themed gifts",
//         discount: 25,
//         code: "SUMMER25",
//         image: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
//         expiry: new Date(Date.now() + 5 * 24 * 60 * 60 * 1000) // 5 days from now
//       },
//       {
//         id: 2,
//         title: "Family Bundle",
//         description: "Buy 3 personalized items, get 1 free",
//         discount: 33,
//         code: "FAMILY33",
//         image: "https://images.unsplash.com/photo-1549056572-75914d6d7e1a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
//         expiry: new Date(Date.now() + 3 * 24 * 60 * 60 * 1000) // 3 days from now
//       },
//       {
//         id: 3,
//         title: "Free Shipping",
//         description: "Free worldwide shipping on orders over $50",
//         discount: 100,
//         code: "FREESHIP",
//         image: "https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
//         expiry: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000) // 7 days from now
//       }
//     ]);
//   }, []);

//   useEffect(() => {
//     // Calculate time remaining for the soonest expiring offer
//     const calculateTimeRemaining = () => {
//       if (offers.length === 0) return;
      
//       // Find the offer with the closest expiry date
//       const soonestOffer = offers.reduce((prev, current) => 
//         prev.expiry < current.expiry ? prev : current
//       );
      
//       const now = new Date();
//       const difference = soonestOffer.expiry - now;
      
//       if (difference > 0) {
//         setTimeRemaining({
//           days: Math.floor(difference / (1000 * 60 * 60 * 24)),
//           hours: Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
//           minutes: Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60)),
//           seconds: Math.floor((difference % (1000 * 60)) / 1000)
//         });
//       }
//     };

//     calculateTimeRemaining();
//     const timer = setInterval(calculateTimeRemaining, 1000);

//     return () => clearInterval(timer);
//   }, [offers]);

//   return (
//     <section className="py-16 bg-gradient-to-r from-purple-50 to-pink-50">
//       <div className="container mx-auto px-4">
//         <div className="text-center mb-12">
//           <h2 className="text-3xl font-bold text-gray-800 mb-4">Exclusive Offers</h2>
//           <p className="text-gray-600 max-w-2xl mx-auto">
//             Limited-time special deals just for our valued customers. Don't miss out on these exclusive offers!
//           </p>
//         </div>

//         {/* Countdown Timer */}
//         <div className="bg-white rounded-xl shadow-lg p-6 mb-12 max-w-2xl mx-auto">
//           <h3 className="text-xl font-semibold text-center mb-4">Hurry! These offers end in:</h3>
//           <div className="flex justify-center space-x-4">
//             <div className="flex flex-col items-center">
//               <div className="bg-purple-100 text-purple-800 rounded-lg w-16 h-16 flex items-center justify-center text-2xl font-bold">
//                 {timeRemaining.days.toString().padStart(2, '0')}
//               </div>
//               <span className="text-sm text-gray-600 mt-2">Days</span>
//             </div>
//             <div className="flex flex-col items-center">
//               <div className="bg-purple-100 text-purple-800 rounded-lg w-16 h-16 flex items-center justify-center text-2xl font-bold">
//                 {timeRemaining.hours.toString().padStart(2, '0')}
//               </div>
//               <span className="text-sm text-gray-600 mt-2">Hours</span>
//             </div>
//             <div className="flex flex-col items-center">
//               <div className="bg-purple-100 text-purple-800 rounded-lg w-16 h-16 flex items-center justify-center text-2xl font-bold">
//                 {timeRemaining.minutes.toString().padStart(2, '0')}
//               </div>
//               <span className="text-sm text-gray-600 mt-2">Minutes</span>
//             </div>
//             <div className="flex flex-col items-center">
//               <div className="bg-purple-100 text-purple-800 rounded-lg w-16 h-16 flex items-center justify-center text-2xl font-bold">
//                 {timeRemaining.seconds.toString().padStart(2, '0')}
//               </div>
//               <span className="text-sm text-gray-600 mt-2">Seconds</span>
//             </div>
//           </div>
//         </div>

//         {/* Offers Grid */}
//         <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
//           {offers.map(offer => (
//             <div key={offer.id} className="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-105">
//               <div className="relative h-48 overflow-hidden">
//                 <img 
//                   src={offer.image} 
//                   alt={offer.title}
//                   className="w-full h-full object-cover"
//                 />
//                 <div className="absolute top-4 right-4 bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">
//                   {offer.discount}% OFF
//                 </div>
//               </div>
              
//               <div className="p-6">
//                 <h3 className="text-xl font-bold text-gray-800 mb-2">{offer.title}</h3>
//                 <p className="text-gray-600 mb-4">{offer.description}</p>
                
//                 <div className="flex items-center justify-between mb-6">
//                   <span className="text-sm text-gray-500">Use code:</span>
//                   <span className="bg-purple-100 text-purple-800 font-mono font-bold px-3 py-1 rounded">
//                     {offer.code}
//                   </span>
//                 </div>
                
//                 <button className="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
//                   Claim Offer Now
//                 </button>
//               </div>
//             </div>
//           ))}
//         </div>

//         {/* Additional CTA */}
//         <div className="text-center mt-12">
//           <p className="text-gray-600 mb-4">Sign up for our newsletter to receive exclusive offers directly in your inbox!</p>
//           <Link 
//             to="/newsletter" 
//             className="inline-block bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:-translate-y-1"
//           >
//             Subscribe Now
//           </Link>
//         </div>
//       </div>
//     </section>
//   );
// };

// export default ExclusiveOffers;