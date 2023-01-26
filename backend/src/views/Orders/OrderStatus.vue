<template>
  <span class="text-white py-1 px-2 rounded " :class="{
      'bg-emerald-500': ['paid', 'completed'].includes(order.status),
      'bg-red-500': order.status === 'cancelled',
      'bg-gray-500': order.status === 'unpaid',
    }">{{ ['paid'].includes(order.status) ? 'Pagado' : order.status==='cancelled' ? 'Cancelado' : order.status==='unpaid' ? 'Por pagar' : 'Completado' }}</span>
</template>

<script setup>
const {order} = defineProps({
  order: Object
})
</script>

<style scoped>

</style>
