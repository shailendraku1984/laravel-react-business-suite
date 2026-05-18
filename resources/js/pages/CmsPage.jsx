import { useEffect, useState } from 'react';

import { useParams } from 'react-router-dom';
import { Helmet } from 'react-helmet-async';
import DOMPurify from 'dompurify';

import MainLayout from '../layouts/MainLayout';

import axios from 'axios';

export default function CmsPage() {

    const { slug } = useParams();

    const [page, setPage] = useState(null);

    const [loading, setLoading] = useState(true);

    useEffect(() => {

        fetchCmsPage();

    }, [slug]);

    const fetchCmsPage = async () => {

        try {

            setLoading(true);

            const response = await axios.get(
                `/api/cms/${slug}`
            );

            setPage(response.data.data);

        } catch (error) {

            console.error(error);

            setPage(null);

        } finally {

            setLoading(false);
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    if (loading) {

        return (

            <MainLayout>

                <div className="container mx-auto py-20 text-center">

                    Loading...

                </div>

            </MainLayout>
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Page Not Found
    |--------------------------------------------------------------------------
    */

    if (!page) {

        return (

            <MainLayout>

                <div className="container mx-auto py-20 text-center">

                    Page not found

                </div>

            </MainLayout>
        );
    }

    return (

        <MainLayout>

            <Helmet>

                <title>
                    {page.meta_title || page.title}
                </title>

                <meta
                    name="description"
                    content={
                        page.meta_description || ''
                    }
                />

            </Helmet>

            <div className="container mx-auto py-10">

                <h1 className="text-3xl font-bold mb-5">

                    {page.title}

                </h1>

                <div
                    className="prose max-w-none"
                    dangerouslySetInnerHTML={{
                        __html: DOMPurify.sanitize(
                            page.content
                        )
                    }}
                />

            </div>

        </MainLayout>
    );
}