import {createStore} from "vuex";
import {PRODUCTS_PER_PAGE, ORDERS_PER_PAGE, USERS_PER_PAGE} from "../constants.js";

const state = {
    user:{
        token: sessionStorage.getItem('TOKEN'),
        data:{}
    },
    products:{
        data:[],
        loading:false,
        links:[],
        from : null,
        to: null ,
        page:1,
        limit: PRODUCTS_PER_PAGE
    },
    orders:{
        data:[],
        loading:false,
        links:[],
        from : null,
        to: null ,
        page:1,
        limit: ORDERS_PER_PAGE
    },
    users:{
        data:[],
        loading:false,
        links:[],
        from : null,
        to: null ,
        page:1,
        limit: USERS_PER_PAGE
    },
    toast:{
        show:false,
        message:''
    },
};

export default state;
