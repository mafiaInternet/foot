import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Head, router, useForm } from '@inertiajs/react';
import React, {useEffect} from 'react';
import axios from 'axios';
const Index = ({auth, categories}) => {
    const {data, setData, post} = useForm({
        name: '',
        name_id: ''
    })
    const handleCreate = (event) => {
        event.preventDefault()
        post(route('category.store'), data)
    }
    const onChange = async (checked, id) => {

        const newData = data.map((item) =>{
            if(item.id == id){
                return {...item, status:checked}
            }
            return item;
        })

        setData(newData)
        try {
            const response = await axios.put(`/category/${id}`, {status: checked});
            console.log("Category updated successfully", response);
        } catch (error) {
            console.error("Error updating category", error);
        }
    };
    const handleDelete = (id) => {
        router.delete(route('category.destroy', id))
    }
    console.log(categories)
    return (
        <Authenticated
        user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Category
                </h2>
            }
        >
            <Head title="Category" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <form className='flex ' onSubmit={handleCreate}>
                                <div className='form--group' >
                                    <label htmlFor='name'>Category Name:    </label>
                                    <input className='mx-3' type='text' id='name' name='name' onChange={(event) => setData('name', event.target.value)} placeholder='Category Name'></input>
                                </div>
                                <div className='form-group '>
                                    <label htmlFor='name_id'>Category ID Name:</label>
                                    <input className='mx-3' type='text' id='name_id' name='name_id' onChange={(event) => setData('name_id', event.target.value)} placeholder='Category ID Name'></input>
                                </div>
                                <button type='submit' className='form--submit bg-green-700 hover:bg-green-600 py-1 px-3'>Create</button>
                            </form>
                        </div>
                        <table className='table w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400'>
                            <thead className='text-xs text-gray-700 uppercase bg-gray-500 dark:bg-gary-700 dark:text-gray-400'>
                                <tr className='text-nowrap'>
                                    <th className='px-3 py-2'>#</th>
                                    <th className='px-3 py-2'>Category Name</th>
                                    <th className='px-3 py-2'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {categories.data.map((category, index) => (
                                    <tr key={index} className='bg-white border-b dark:bg-gray-800 dark:border-grayp-700'>
                                        <td className='px-3 py-2'>{category.id}</td>
                                        <td className='px-3 py-2'>{category.name}</td>
                                        <td className='px-3 py-2'><button className='btn btn-range' onClick={() => handleDelete(category.id)}>Delete</button></td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}

export default Index;
