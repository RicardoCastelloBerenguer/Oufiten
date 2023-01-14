export function setUser(state,user){
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
    debugger;
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
