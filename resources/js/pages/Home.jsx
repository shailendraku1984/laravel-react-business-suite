import React, { useEffect, useState } from 'react';
import { Link  } from 'react-router-dom';
import MainLayout from '../layouts/MainLayout';
import ProductCard from '../components/ProductCard';

import api from '../services/api';

export default function Home() {

    const [products, setProducts] = useState([]);

    const [loading, setLoading] = useState(true);

    useEffect(() => { fetchProducts(); }, []);

    const fetchProducts = async () => {

        try {

            const response = await api.get('/products');

            setProducts(response.data.products);

        } catch (error) {

            console.log(error);

        } finally {

            setLoading(false);
        }
    };

    if (loading) {

        return (

            <div className="min-h-screen flex items-center justify-center">

                <div className="text-xl font-semibold">
                    Loading products...
                </div>

            </div>
        );
    }

    return (

        <MainLayout>

            {/* Hero Section */}

            <section className="bg-indigo-600 text-white py-24">

                <div className="max-w-7xl mx-auto px-6 text-center">

                    <h1 className="text-5xl font-bold mb-6">
                        Family Health & Protection
                    </h1>

                    <p className="text-xl text-indigo-100 max-w-3xl mx-auto leading-8">
                        Focus on protection, cleanliness, or self-care.
                    </p>

                    <button className="mt-8 bg-white text-indigo-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition">
                        
						<Link to="/products">Shop Now</Link>
                    </button>

                </div>

            </section>

            {/* Product Section */}

            <section className="max-w-7xl mx-auto px-6 py-16">

                <div className="flex items-center justify-between mb-10">

                    <h2 className="text-3xl font-bold text-gray-800">
                        Featured Products
                    </h2>

                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                    {products.map((product) => (

                        <ProductCard
                            key={product.id}
                            product={product}
                        />

                    ))}

                </div>

            </section>

        </MainLayout>
    );
}