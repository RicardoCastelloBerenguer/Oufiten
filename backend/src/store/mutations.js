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
}
