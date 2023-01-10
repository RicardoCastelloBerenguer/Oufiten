import {createStore} from "vuex";
import {PRODUCTS_PER_PAGE} from "../constants.js";

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
    }
};

export default state;
