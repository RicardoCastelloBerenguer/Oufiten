import axiosClient from "../axios.js";

export function login({commit},data){
    return axiosClient.post('/login',data).then(({data})=>{
        commit('setUser',data.user);
        commit('setToken',data.token);
        return data;
    })
}

export function logout({commit}){
    return axiosClient.post('/logout').then((response) => {
        commit('setToken',null);
        return response;
    })
}

export function getUser({commit},data)
{
    return axiosClient.get('/user',data).then((data =>{
        commit('setUser', data);
        return data.data;
    }))
}

export function getProducts({commit} , {url = null,search='',perPage,sortBy,order} = {})
{
    commit('setProducts', [true]);
    url = url || '/products'
    return axiosClient.get(url,{
        params:{
            search,
            per_page:perPage,
            sortBy,
            order
        }
    })
        .then((res =>{
        commit('setProducts', [false,res.data]);
    })).catch((error) => {
        console.log(error)
        commit('setProducts', [false]);
    })
}
export function getProduct({},id){
    return axiosClient.get(`/products/${id}`);
}
export function createProduct({commit} , product){
    if(product.image instanceof File){
        const form = new FormData();
        form.append('title',product.title);
        form.append('image',product.image);
        form.append('description',product.description);
        form.append('price',product.price);
        product = form;
    }
    return axiosClient.post('/products',product);
}

export function updateProduct({commit} , product){
    const id = product.id;
    if(product.image instanceof File){
        const form = new FormData();
        form.append('id',product.id);
        form.append('title',product.title);
        form.append('image',product.image);
        form.append('description',product.description);
        form.append('price',product.price);
        form.append('_method','PUT');
        product = form;
    }else {
        product._method='PUT';
    }
    return axiosClient.post(`/products/${id}`,product);
}
export function deleteProduct({commit} , id){
    return axiosClient.delete(`/products/${id}`);
}
