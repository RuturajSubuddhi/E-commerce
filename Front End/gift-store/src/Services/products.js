import api from "../api";

/**
 * ✅ Fetch all trending products
 * Laravel: GET /api/home/trending/product/get
 */
export const getTrendingProducts = async () => {
  try {
    const res = await api.get("/home/trending/product/get");
    console.log("🟢 [API] Trending Products:", res.data);
    return res.data.data || res.data;
  } catch (error) {
    console.error("🔴 [API Error] Trending Products:", error);
    throw error;
  }
};

/**
 * ✅ Fetch products by subcategory
 * Laravel: GET /api/home/subcategory/product?subCategory_id=13
 */
export const getProductsBySubcategory = async (subCategory_id) => {
  try {
    const res = await api.get("/home/subcategory/product", {
      params: { subCategory_id },
    });

    console.log("🟢 [API Raw Response] Products by Subcategory:", res.data);

    // ✅ Handle nested structure: { data: { data: [...] } }
    const products = res.data?.data?.data || res.data?.data || [];
    console.log("🟢 [Parsed Products]:", products);

    return products;
  } catch (error) {
    console.error("🔴 [API Error] Subcategory:", subCategory_id, error);
    throw error;
  }
};

/**
 * ✅ Fetch single product details
 * Laravel: GET /api/product/details?id=5
 */
export const getProductDetails = async (id) => {
  try {
    const res = await api.get(`/product/details?id=${id}`);
    console.log("🟢 [API] Product Details:", id, res.data);
    return res.data.data || res.data;
  } catch (error) {
    console.error("🔴 [API Error] Product Details:", id, error);
    throw error;
  }
};

/**
 * ✅ Fetch products within a price range
 * Laravel: POST /api/product/price/range/src
 */
export const getProductsByPriceRange = async (filters) => {
  try {
    const res = await api.post("/product/price/range/src", filters);
    console.log("🟢 [API] Price Range:", filters, res.data);
    return res.data.data || res.data;
  } catch (error) {
    console.error("🔴 [API Error] Price Range:", filters, error);
    throw error;
  }
};
