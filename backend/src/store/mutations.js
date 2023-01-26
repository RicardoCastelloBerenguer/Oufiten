export function setCurrentUser(state,user){
    state.user.data=user.data;
}
export function setToken(state,token){
    state.user.token = token;
    if(token){
        sessionStorage.setItem('TOKEN',token);
    }
    else{
        sessionStorage.removeItem('TOKEN');
    }
}

export function setProducts(state,[loading,response= null]){
    if(response){
        state.products = {
            data : response.data,
            links : response.meta.links,
            total : response.meta.total,
            page : response.meta.current_page,
            limit : response.meta.per_page,
            from : response.meta.from,
            to : response.meta.to,
        }
    }
    state.products.loading=loading;
}
export function setUsers(state,[loading,response= null]){
    if(response){
        state.users = {
            data : response.data,
            links : response.meta.links,
            total : response.meta.total,
            page : response.meta.current_page,
            limit : response.meta.per_page,
            from : response.meta.from,
            to : response.meta.to,
        }
    }
    state.users.loading=loading;
}

export function setOrders(state,[loading,response= null]){
    if(response){
        state.orders = {
            data : response.data,
            links : response.meta.links,
            total : response.meta.total,
            page : response.meta.current_page,
            limit : response.meta.per_page,
            from : response.meta.from,
            to : response.meta.to,
        }
    }
    state.orders.loading=loading;
}

export function setCustomers(state,[loading,response= null]){
    if(response){
        state.customers = {
            data : response.data,
            links : response.meta.links,
            total : response.meta.total,
            page : response.meta.current_page,
            limit : response.meta.per_page,
            from : response.meta.from,
            to : response.meta.to,
        }
    }
    state.customers.loading=loading;
}

export function showToast(state,[message,type=null]){
    state.toast.show=true;
    state.toast.message=message
    if(type){
        state.toast.type=type;
    }
}
export function hideToast(state){
    state.toast.show=false;
    state.toast.message='';
    state.toast.type='success';
}
