import React from 'react';
import { Link  } from 'react-router-dom';
export default function Footer() {

    return (

        <footer className="bg-gray-900 text-white mt-20">

            <div className="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">

                <div>

                    <h3 className="text-xl font-semibold mb-4">
                        Quick Links
                    </h3>

                    <ul className="space-y-3 text-gray-400">
						<li><Link to="/">Home</Link></li>
                        <li><Link to="/login">Login</Link></li>
                        <li><Link to="/register">Register</Link></li>
                    </ul>

                </div>

                <div>

                    <h3 className="text-xl font-semibold mb-4">
                        More Links
                    </h3>

                    <ul className="space-y-3 text-gray-400">
						<li><Link to="/about-us">About Us</Link></li>
						<li><Link to="/contact-us">Contact Us</Link></li>
						<li><Link to="/term-and-conditions">Term Of Uses</Link></li>
                    </ul>

                </div>

                <div>

                    <h3 className="text-xl font-semibold mb-4">
                        Important
                    </h3>

                    <ul className="space-y-3 text-gray-400">
						<li><Link to="/faq">FAQ</Link></li>
                        <li><Link to="/refund-policy">Refund Policy</Link></li>
						<li><Link to="/privacy-policy">Privacy Policy</Link></li>
                    </ul>

                </div>

            </div>

            <div className="border-t border-gray-800 text-center py-4 text-gray-500 text-sm">
                © 2026 Counter Sale. All rights reserved.
            </div>

        </footer>
    );
}