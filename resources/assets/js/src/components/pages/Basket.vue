<template>
<div id="basket-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-xs-8">
        <div class="panel panel-info">
          <div class="panel-heading">
            <div class="panel-title">
              <div class="row">
                <div class="col-xs-6">
                  <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
                </div>
                <div class="col-xs-6">
                  <button type="button" class="btn btn-primary btn-sm btn-block">
                  <router-link tag="li" :to="{ name: 'products' }">
                    <span class="glyphicon glyphicon-share-alt"></span> Continue shopping
                  </router-link>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div v-for="order in orders" class="panel-body">
            <div class="row">
              <div class="col-xs-2"><img class="img-responsive" :src="'/storage/' + order.preview">
              </div>
              <div class="col-xs-4">
                <h4 class="product-name"><strong>{{ order.title }}</strong></h4>
              </div>
              <div class="col-xs-6">
                <div class="col-xs-6 text-right">
                  <h6><strong>{{ order.price }}<span class="text-muted">$</span></strong></h6>
                </div>
                <div class="col-xs-4">
                  <input @change="getTotalPriceWithQuantity(order.id)" 
                    type="number"
                    min="1"
                    :id="order.id"
                    class="form-control input-sm" 
                    :value="order.quantity">
                </div>
                <div class="col-xs-2">
                  <button type="button" class="btn btn-link btn-xs">
                  <span @click="handleDelete(order.id)" class="glyphicon glyphicon-trash"> </span>
                  </button>
                </div>
              </div>
              <hr>
            </div>
          </div>
          <div class="panel-footer">
            <div class="row text-center">
              <div class="col-xs-9">
                <h4 class="text-right">Total <strong>${{ totalPrice }}</strong></h4>
              </div>
              <div class="col-xs-3">
                <button @click="handleSubmit" v-if="orders.length > 0" type="button" class="btn btn-success btn-block">
                  Checkout
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import { getHeaders } from './../../../config/env'
import swal from 'sweetalert'

export default {
  name: 'basket',
  data () {
    return {
      orders: [],
      totalPrice: 0
    }
  },
  methods: {
    handleSubmit () {
      const orders = this.orders
      this.$http.put('api/orders', { orders }, { headers: getHeaders() })
        .then(() => swal('Success!', 'Await for call on your phone or letter on your email from our manager', 'success'))
        .then(() => {
          this.orders = []
          this.totalPrice = 0
        })
    },
    getOrders () {
      this.$http.get('api/orders', { headers: getHeaders() })
        .then(response => {
          this.orders = response.data
        })
        .then(() => this.getTotalPrice())
    },
    getTotalPrice () {
      const prices = this.orders.map(order => {
        return order.price * order.quantity
      })

      this.totalPrice = prices.reduce((sum, current) => {
        return sum + current
      }, 0)
    },
    getTotalPriceWithQuantity (id) {
      const quantity = document.getElementById(id).value

      this.orders = this.orders.map(order => {
        if (order.id === id) {
          order.quantity = quantity
        }
        return order
      })

      this.getTotalPrice()
    },
    handleDelete (id) {
      this.$http.delete(`api/orders/${id}`, { headers: getHeaders() })
        .then(() => {
          this.orders = this.orders.filter(order => order.id !== id)
        })
        .then(() => this.getTotalPrice())
        .then(() => swal('Success!', 'The product was deleted from your basket', 'success'))
    }
  },
  created () {
    this.getOrders()
  }
}
</script>

<style scoped>
#basket-wrapper {
  margin-left: 17%;
}
</style>