import {ref} from "vue";

export const PRODUCTS_PER_PAGE=10;

export const ORDERS_PER_PAGE=10;
export const USERS_PER_PAGE=10;
export const DEFAULT_EMPTY_MODEL_PRODUCT = {
    id:'',
    title:'',
    image:'',
    price:'',
    description:'',
}

export const orderStatus = ['unpaid','paid','cancelled','completed']
