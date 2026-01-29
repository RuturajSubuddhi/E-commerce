import React from 'react'
import { Routes, Route } from 'react-router-dom'
import Home from '../pages/Home'
import WishlistPage from '../pages/WishlistPage'
// import Shop from '../pages/Shop'
// import ProductPage from '../pages/ProductPage'
// import CartPage from '../pages/CartPage'
// import NotFound from '../pages/NotFound'
import CatagorySlider from '../components/Home/CategorySlider'
import DropDownMenu from '../components/Home/DropDownMenu'
import Navbar from '../components/Home/Navbar'
import PromoBar from '../components/Home/PromoBar'
import NewArrivalBanner from '../components/Home/NewArrivalBanner'
import KatanaBanner from '../components/Home/KatanaBanner'
import GiftBanner from '../components/Home/GiftBanner'
import Features from '../components/Home/Features'
import StockAdBanner from '../components/Home/StockAdBanner'
import ItemCarousel from '../components/Home/ItemCarousel'
import FreeKeyChainBanner from '../components/Home/FreeKeyChainBanner'
import CartPage from '../pages/CartPage'
import CheckoutPage from '../pages/CheckoutPage'
import ProductDetails from '../pages/ProductDetails'
import ItemDetails from '../pages/ItemDetails'
import ViewAllItems from '../pages/ViewAllItems'
import AllExpensiveItems from '../pages/AllExpensiveItems'
import AuthModal from '../components/Auth/AuthModal'


import AdminUsers from '../pages/AdminUser'
import WeaponListPage from '../pages/Catagories/Weapons/WeaponListPage'
import WeaponDetailsPage from '../pages/Catagories/Weapons/WeaponDetailsPage'
import AFListPage from '../pages/Catagories/ActonFigures/AFListPage'
import AFProductDetails from '../pages/Catagories/ActonFigures/AFProductDetails'
import PosterProductsList from '../pages/Catagories/Posters/PosterProductsList'
import PosterProductDetails from '../pages/Catagories/Posters/PosterProductDetails'
import DeskMateProductsList from '../pages/Catagories/DeskMates/DeskMateProductsList'
import DeskMateProductDetails from '../pages/Catagories/DeskMates/DeskMateProductDetails'
import MerchListPage from '../pages/Catagories/Merch/MerchListPage'
import MerchDetailsPage from '../pages/Catagories/Merch/MerchDetailsPage'
import PrivacyPolicyPage from '../components/Footers/PrivacyPolicyPage'
import KeychainsListPage from '../pages/Catagories/Keychains/KeychainsListPage'
import KeychainsDetailsPage from '../pages/Catagories/Keychains/KeychainsDetailsPage'
import TermsConditionsPage from '../components/Footers/TermsConditionsPage'
import RefundCancellationPage from '../components/Footers/RefundCancellationPage'
import ReturnPolicyPage from '../components/Footers/ReturnPolicyPage'
import ShippingPolicyPage from '../components/Footers/ShippingPolicyPage'
import AboutUsPage from '../components/Footers/AboutUsPage'
import MyOrdersPage from '../components/Footers/MyOrdersPage'
import ChangePasswordProfile from '../components/Auth/ChangePasswordProfile'
import ProfileDetails from '../components/Auth/ProfileDetails'
import CategoryListing from '../pages/Catagories/CategoryListing'
import CategoryDetails from '../pages/Catagories/CategoryDetails'
import SavedAddressesPage from '../components/Auth/SavedAddressesPage'
import ForgetPassword from '../components/Auth/ForgetPassword'
import SearchPage from '../pages/SearchPage'
// import ContactUsPage from '../components/Footers/ContactUsPage'







export default function AppRoutes() {
  return (
    <Routes>
      <Route path="/" element={<Home />} />
      {/* <Route path="/CatagorySlider" element={<CatagorySlider />} />
      <Route path="/DropDownMenu" element={<DropDownMenu />} />
      <Route path="/Navbar" element={<Navbar />} />
      <Route path="/PromoBar" element={<PromoBar />} /> */}
      <Route path="/NewArrivalBanner" element={<NewArrivalBanner />} />
      <Route path="/KatanaBanner" element={<KatanaBanner />} />
      <Route path="/GiftBanner" element={<GiftBanner />} />
      <Route path="/Features" element={<Features />} />
      <Route path="/StockAdBanner" element={<StockAdBanner />} />
      <Route path="/ItemCarousel" element={<ItemCarousel />} />
      <Route path="/FreeKeyChain" element={<FreeKeyChainBanner
      />} />

      <Route path="/cart" element={<CartPage />} />
      <Route path="/wishlist" element={<WishlistPage />} />

      <Route path="/privacy-policy" element={< PrivacyPolicyPage />} />
      <Route path="/terms-and-conditions" element={<TermsConditionsPage />} />
      <Route path="/refund-and-cancellation-policy" element={<RefundCancellationPage />} />
      <Route path="/return-policy" element={<ReturnPolicyPage />} />
      <Route path="/shipping-policy" element={<ShippingPolicyPage />} />
      <Route path="/about-us" element={<AboutUsPage />} />
      <Route path="/myorder" element={<MyOrdersPage />} />
      <Route path="/change-password" element={<ChangePasswordProfile />} />
      <Route path="/myprofile" element={<ProfileDetails />} />
      <Route path="/forget-password" element={<ForgetPassword/>} />



      <Route path="/checkout" element={<CheckoutPage />} />
      <Route path="/product/:id" element={<ProductDetails />} />
      <Route path="/item/:id" element={<ItemDetails />} />
      <Route path="/items" element={<ViewAllItems />} />
      <Route path="/expensive-items" element={<AllExpensiveItems />} />
      <Route path="/Register" element={<AuthModal />} />

      <Route path="/catagories/action-figures/:subcategoryId" element={<AFListPage />} />
      <Route path="/catagories/action-figures/details/:id" element={<AFProductDetails />} />

      <Route path="/admin/users" element={<AdminUsers />} />

      <Route path="/catagories/Weapons/:subcategoryId" element={<WeaponListPage />} />
      <Route path="/catagories/Weapons/details/:id" element={<WeaponDetailsPage />} />

      <Route path="/catagories/Posters/:subcategoryId" element={<PosterProductsList />} />
      <Route path="/catagories/Posters/details/:id" element={<PosterProductDetails />} />

      <Route path="/catagories/Deskmates/:subcategoryId" element={<DeskMateProductsList />} />
      <Route path="/catagories/Deskmates/details/:id" element={<DeskMateProductDetails />} />

      <Route path="/catagories/Merch/:subcategoryId" element={<MerchListPage />} />
      <Route path="/catagories/Merch/details/:id" element={<MerchDetailsPage />} />

      <Route path="/catagories/keychains/:subcategoryId" element={<KeychainsListPage />} />
      <Route path="/catagories/keychains/details/:id" element={<KeychainsDetailsPage />} />

      <Route path="/category/:id" element={<CategoryListing />} />
      <Route path="/category/details/:id" element={<CategoryDetails />} />
      {/* <Route path="/category/details/:productId" element={<CategoryDetails />} /> */}

      <Route path="/save-address" element={<SavedAddressesPage />} />
      <Route path="/search" element={<SearchPage />} />

    </Routes>
  )
}
