import Authenticated from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import React, { useEffect } from "react";

const Show = ({ auth, categories, product }) => {
    console.log(product);
    const { data, setData, post, put, processing, errors } = useForm({
        title: "",
        imageUrls: [],
        category_id: null,
        quantity: null,
        price: null,
        discountedPrice: null,
        discountedPersent: null,
        description: null,
    });

    const handleFileChange = (e) => {
        const files = Array.from(e.target.files); // Chuyển đổi FileList thành mảng
        const imageUrls = files.map((file) => URL.createObjectURL(file)); // Tạo URL cho mỗi tệp

        setData("imageUrls", imageUrls);
    };

    const handleSubmit = (e, id) => {
        e.preventDefault();
        const action = e.nativeEvent.submitter.name;
        setData("discountedPrice", (data.price * data.discountedPersent) / 100);

        if (action == "update") {
            put(`/product/${id}`);
        } else if (action == "create") {
            post("/product");
        }
    };

    useEffect(() => {
        if (product) {
            setData(product);
        }
    }, [product]);
    console.log(product);  
    return (
        <Authenticated
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Thêm sản phẩm
                </h2>
            }
        >
            <Head title="Thêm sản phẩm" />

            {data && (
                <div className="py-12 dark-mode">
                    <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                            <div className="p-6 text-gray-900 dark:text-gray-100">
                                <form
                                    className="grid grid-cols-1 gap-4"
                                    onSubmit={(e) => handleSubmit(e, data.id)}
                                >
                                    <div className="grid grid-cols-2 gap-4">
                                        <div className="form--group ">
                                            <label htmlFor="title">Title</label>
                                            <input
                                                className="w-full text-gray-600"
                                                type="text"
                                                id="title"
                                                name="title"
                                                value={data.title}
                                                onChange={(e) =>
                                                    setData({
                                                        ...data,
                                                        title: e.target.value,
                                                    })
                                                }
                                                placeholder="Tên sản phẩm"
                                            ></input>
                                        </div>
                                        <div className="form--group">
                                            <label htmlFor="category">
                                                Thể loại
                                            </label>
                                            <select
                                                className="w-full text-gray-600"
                                                id="category"
                                                name="category"
                                                onChange={(event) =>
                                                    setData({
                                                        ...data,
                                                        category_id: Number(
                                                            event.target.value
                                                        ), // Parse để lấy object category
                                                    })
                                                }
                                            >
                                                {categories.data.map(
                                                    (category, index) => (
                                                        <option
                                                            className="text-gray-600"
                                                            value={category.id}
                                                            key={index}
                                                        >
                                                            {category.name}
                                                        </option>
                                                    )
                                                )}
                                            </select>
                                        </div>
                                    </div>

                                    <div className="form--group">
                                        <label htmlFor="imageUrl">
                                            ImageUrl
                                        </label>
                                        <input
                                            className="w-full border-solid border-2 border-gray-600 "
                                            type="file"
                                            multiple
                                            id="imageUrl"
                                            name="imageUrl"
                                            onChange={handleFileChange}
                                        ></input>
                                    </div>
                                    <div className="grid grid-cols-12 gap-3">
                                        {data.imageUrls.length > 0 &&
                                            data.imageUrls.map(
                                                (item, index) => (
                                                    <img
                                                        key={index}
                                                        src={item}
                                                      
                                                    ></img>
                                                )
                                            )}
                                    </div>
                                    <div className="grid grid-cols-3 gap-4">
                                        <div className="form--group">
                                            <label htmlFor="price">
                                                Đơn giá
                                            </label>
                                            <input
                                                className="w-full text-gray-600"
                                                type="number"
                                                id="price"
                                                name="price"
                                                placeholder="Đơn giá"
                                                value={data.price}
                                                onChange={(e) =>
                                                    setData({
                                                        ...data,
                                                        price: Number(
                                                            e.target.value
                                                        ),
                                                    })
                                                }
                                            ></input>
                                        </div>
                                        <div className="form--group">
                                            <label htmlFor="discountedPersent">
                                                Chiết khấu
                                            </label>
                                            <input
                                                className="w-full text-gray-600"
                                                type="number"
                                                id="discountedPersent"
                                                name="discountedPersent"
                                                placeholder="Chiết khấu phần trăm"
                                                value={data.discountedPersent}
                                                onChange={(e) =>
                                                    setData({
                                                        ...data,
                                                        discountedPersent:
                                                            Number(
                                                                e.target.value
                                                            ),
                                                    })
                                                }
                                            ></input>
                                        </div>
                                        <div className="form--group">
                                            <label htmlFor="quantity">
                                                Số lượng
                                            </label>
                                            <input
                                                className="w-full text-gray-600"
                                                type="number"
                                                id="quantity"
                                                name="quantity"
                                                placeholder="Số lượng"
                                                value={data.quantity}
                                                onChange={(e) =>
                                                    setData({
                                                        ...data,
                                                        quantity: Number(
                                                            e.target.value
                                                        ),
                                                    })
                                                }
                                            ></input>
                                        </div>
                                    </div>
                                    <div className="form--group">
                                        <label htmlFor="description">
                                            Mô tả
                                        </label>
                                        <textarea
                                            className="w-full border-solid border-2 border-gray-600 text-black"
                                            id="description"
                                            type="text"
                                            name="description"
                                            value={data.description}
                                            onChange={(e) =>
                                                setData(
                                                    "description",
                                                    e.target.value
                                                )
                                            }
                                            multiple
                                        ></textarea>
                                    </div>
                                    {product != null ? (
                                    <button className="bg-green-700 hover:bg-green-600 px-1 py-1 rounded" type="submit" name="update">Update</button>

                                    ): 
                                    (<button
                                        className="bg-green-700 hover:bg-green-600 px-1 py-1 rounded"
                                        type="submit"
                                        name="create"
                                        data="create"
                                    >
                                        Lưu
                                    </button>)
                             
                                    }
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </Authenticated>
    );
};

export default Show;
