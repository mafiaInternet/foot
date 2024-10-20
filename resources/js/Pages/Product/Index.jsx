import Authenticated from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import React from "react";
const Index = ({ auth, products }) => {

    const handleFindProductById = (id) => {
        router.get(route("product.show", id));
    };
    const handleDeleteProduct = (id) => {
        router.delete(route("product.deleteProductById", id));
    };
    return (
        <Authenticated
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Product
                </h2>
            }
        >
            <Head title="Category" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-4">
                        <Link className="mb-4 rounded-md text-gray-200 bg-blue-700 hover:bg-blue-600 text-base py-1 px-3" href={route("product.create")}>Thêm </Link>

                        </div>
                        {products.data != null && (
                            <table className="table w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-500 dark:bg-gary-700 dark:text-gray-400">
                                    <tr className="text-nowrap">
                                        <th className="px-3 py-2">#</th>
                                        <th className="px-3 py-2">Product</th>
                                        <th className="px-3 py-2">Category</th>
                                        <th className="px-3 py-2">Quantity</th>
                                        <th className="px-3 py-2">Price</th>
                                        <th className="px-3 py-2">
                                            DiscountedPersent
                                        </th>
                                        <th className="px-3 py-2">Create At</th>
                                        <th className="px-3 py-2">Status</th>
                                        <th className="px-3 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {products.data.map((product, index) => (
                                        <tr
                                            key={index}
                                            className="bg-white border-b dark:bg-gray-800 dark:border-grayp-700"
                                        >
                                            <td className="px-3 py-2">
                                                {product.id}
                                            </td>
                                            <td className="px-3 py-2">
                                                {product.title}
                                            </td>
                                            <td className="px-3 py-2">
                                                {product.category.name}
                                            </td>
                                            <td className="px-3 py-2">
                                                {product.quantity}
                                            </td>
                                            <td className="px-3 py-2">
                                                {product.price}
                                            </td>
                                            <td className="px-3 py-2">
                                                {product.discountedPersent}
                                            </td>
                                            <td className="px-3 py-2">
                                                {product.createAt}
                                            </td>
                                            <td className="px-3 py-2"></td>

                                            <td className="px-3 py-2">
                                                <button
                                                    className="btn btn-success mr-1 text-blue-700 hover:text-blue-600"
                                                    onClick={(e) =>
                                                        handleFindProductById(
                                                            product.id
                                                        )
                                                    }
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    className="btn btn-range ml-1 text-red-700 hover:text-red-600"
                                                    onClick={(e) =>
                                                        handleDeleteProduct(
                                                            product.id
                                                        )
                                                    }
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        )}
                    </div>
                </div>
            </div>
        </Authenticated>
    );
};

export default Index;
