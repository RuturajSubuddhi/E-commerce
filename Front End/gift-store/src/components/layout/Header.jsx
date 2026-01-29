// import React from "react";
// import { Routes, Route } from "react-router-dom";
// import PromoBar from "../Home/PromoBar";
// import Navbar from "../Home/CategorySlider";
// import CategorySlider from "../Home/Navbar";
// import DropdownMenu from "../Home/DropDownMenu";
// import NewArrivalBann from "../Home/NewArrivalBanner";
// import KatanaBanner from "../Home/KatanaBanner";
// import GiftBanner from "../Home/GiftBanner";
// import Features from "../Home/Features";
// import StockAdBanner from "../Home/StockAdBanner";
// import ItemCarousel from "../Home/ItemCarousel";
// import FreeKeyChainBanner from "../Home/FreeKeyChainBanner";
// import ExpensiveItemsCarousel from "../Home/ExpensiveItemsCarousel";
// import ProductShowCase from "../Home/ProductShowCase";

// export default function Header() {
//   return (
//     <>
//       <PromoBar />
//       {/* <DropdownMenu/> */}
//        <CategorySlider />

//       <Navbar />
//       <NewArrivalBann/>
//       <KatanaBanner/>
//       <ExpensiveItemsCarousel/>
//       <ProductShowCase/>
//       <FreeKeyChainBanner/>
//       <ItemCarousel/>

//       <StockAdBanner/>
//       <Features/>
//       <GiftBanner/>


//     </>
//   );
// }
import React from "react";
import AppNavbar from "../Home/Navbar"; // Your Navbar component
import PromoBar from "../Home/PromoBar";


export default function Header() {
  return (
    <>
      <PromoBar />
      <AppNavbar />
    </>
  );
}

