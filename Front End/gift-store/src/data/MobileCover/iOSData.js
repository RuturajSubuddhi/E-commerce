export const iosData = [
    {
        id: 1,
        brand: "Apple",
        model: "iPhone 11",
        type: "iOS",
        price: 1399,
        oldPrice: 1799,
        discount: 66,
        img: "/assets/mobileCover/IOS/iphone11-1.webp",
    },
    {
        id: 2,
        brand: "Apple",
        model: "iPhone 11 Pro",
        type: "iOS",
        price: 1499,
        oldPrice: 1899,
        discount: 66,
        img: "/assets/mobileCover/IOS/iphone11-2.jpeg",
    },
    {
        id: 3,
        brand: "Apple",
        model: "iPhone 13 Pro",
        type: "iOS",
        price: 1699,
        oldPrice: 2099,
        discount: 66,
        img: "/assets/mobileCover/IOS/iphone11pro-1.webp",
    },
    {
        id: 4,
        brand: "Apple",
        model: "iPhone 14 Pro Max",
        type: "iOS",
        price: 1799,
        oldPrice: 2199,
        discount: 66,
        img: "/assets/mobileCover/IOS/iphone11pro-2.webp",
    },
    {
        id: 5,
        brand: "Apple",
        model: "iPhone 14 Pro Max",
        type: "iOS",
        price: 1799,
        oldPrice: 2199,
        discount: 66,
        img: "/assets/mobileCover/IOS/iphone13pro-1.webp",
    },
    {
        id: 6,
        brand: "Apple",
        model: "iPhone 14 Pro Max",
        type: "iOS",
        price: 1799,
        oldPrice: 2199,
        discount: 66,
        img: "/assets/mobileCover/IOS/iphone13pro-2.webp",
    },
];

// 🔍 Filter function
export const filteriOSData = (filterText) => {
    return iosData.filter(
        (item) =>
            item.brand.toLowerCase().includes(filterText.toLowerCase()) ||
            item.model.toLowerCase().includes(filterText.toLowerCase()) ||
            item.type.toLowerCase().includes(filterText.toLowerCase())
    );
};
