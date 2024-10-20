import Authenticated from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import React from "react";

const Index = ({ auth, users }) => {


    return (
        <Authenticated
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    User
                </h2>
            }
        >
            <Head title="Category" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-4">
                            <Link
                                className="mb-4 rounded-md text-gray-200 bg-blue-700 hover:bg-blue-600 text-base py-1 px-3"
                                href={route("user.create")}
                            >
                                Thêm
                            </Link>
                        </div>
                        {users.data != null && (
                            <table className="table w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-500 dark:bg-gary-700 dark:text-gray-400">
                                    <tr className="text-nowrap">
                                        <th className="px-3 py-2">#</th>
                                        <th className="px-3 py-2">Name</th>
                                        <th className="px-3 py-2">Email</th>
                                        <th className="px-3 py-2">Create At</th>
                                        <th className="px-3 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {users.data.map((user, index) => (
                                        <tr
                                            key={index}
                                            className="bg-white border-b dark:bg-gray-800 dark:border-grayp-700"
                                        >
                                            <td className="px-3 py-2">
                                                {user.id}
                                            </td>
                                            <td className="px-3 py-2">
                                                {user.name}
                                            </td>

                                            <td className="px-3 py-2">
                                                {user.email}
                                            </td>
                                            <td className="px-3 py-2">
                                                {user.createAt}
                                            </td>
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
