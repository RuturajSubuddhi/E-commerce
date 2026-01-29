export const androidData = [
    {
        id: 1,
        brand: "Oppo",
        model: "Oppo F25 Pro",
        type: "Android",
        price: 1199,
        oldPrice: 1499,
        discount: 66,
        img: "/assets/mobileCover/Android/oppo-1.webp",
    },

    {
        id: 2,
        brand: "Oppo",
        model: "Oppo F25 Pro",
        type: "Android",
        price: 1199,
        oldPrice: 1499,
        discount: 66,
        img: "/assets/mobileCover/Android/oppo-2.webp",
    },

    {
        id: 3,
        brand: "Oppo",
        model: "Oppo F25 Pro",
        type: "Android",
        price: 1199,
        oldPrice: 1499,
        discount: 66,

        img: "/assets/mobileCover/Android/oppo-3.webp",
    },

    {
        id: 4,
        brand: "Vivo",
        model: "Vivo V30",
        type: "Android",
        price: 1299,
        oldPrice: 1699,
        discount: 66,
        img: "/assets/mobileCover/Android/vivo-1.webp",
    },

    {
        id: 5,
        brand: "Vivo",
        model: "Vivo V30",
        type: "Android",
        price: 1299,
        oldPrice: 1699,
        discount: 66,
        img: "/assets/mobileCover/Android/vivo-2.webp",
    },

    {
        id: 6,
        brand: "Vivo",
        model: "Vivo V30",
        type: "Android",
        price: 1299,
        oldPrice: 1699,
        discount: 66,
        img: "/assets/mobileCover/Android/vivo-3.webp",
    },
    {
        id: 7,
        brand: "Realme",
        model: "Realme Narzo 70",
        type: "Android",
        price: 1099,
        oldPrice: 1399,
        discount: 66,
        img: "/assets/mobileCover/Android/realme-1.webp",
    },
    {
        id: 8,
        brand: "Realme",
        model: "Realme Narzo 70",
        type: "Android",
        price: 1099,
        oldPrice: 1399,
        discount: 66,
        img: "/assets/mobileCover/Android/realme-2.webp",
    },
    {
        id: 9,
        brand: "Realme",
        model: "Realme Narzo 70",
        type: "Android",
        price: 1099,
        oldPrice: 1399,
        discount: 66,
        img: "/assets/mobileCover/Android/realme-3.webp",
    },
    {
        id: 10,
        brand: "Samsung",
        model: "Samsung S24 Ultra",
        type: "Android",
        price: 1499,
        oldPrice: 1899,
        discount: 66,
        img: "/assets/mobileCover/Android/samsung-1.webp",
    },
    {
        id: 11,
        brand: "Samsung",
        model: "Samsung S24 Ultra",
        type: "Android",
        price: 1499,
        oldPrice: 1899,
        discount: 66,
        img: "/assets/mobileCover/Android/samsung-2.webp",
    },
    {
        id: 12,
        brand: "Samsung",
        model: "Samsung S24 Ultra",
        type: "Android",
        price: 1499,
        oldPrice: 1899,
        discount: 66,
        img: "/assets/mobileCover/Android/samsung-3.webp",
    },
];

// 🔍 Filter function
export const filterAndroidData = (filterText) => {
    return androidData.filter(
        (item) =>
            item.brand.toLowerCase().includes(filterText.toLowerCase()) ||
            item.model.toLowerCase().includes(filterText.toLowerCase()) ||
            item.type.toLowerCase().includes(filterText.toLowerCase())
    );
};
