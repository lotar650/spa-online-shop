<template>
  <div id="products-wrapper">
    <div class="container">
        <div class="input-group stylish-input-group">
            <input v-model="search" type="text" class="form-control"  placeholder="Search" >
            <span class="input-group-addon">
                <button type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>  
            </span>
        </div>
        <br>
        <div id="products" class="row list-group">
            <div v-for="(product, index) in filteredProducts" v-if="index < pagination.count" class="product item col-xs-4 col-lg-4">
                <div class="thumbnail">
                    <img class="preview group list-group-image" :src="'/storage/' + product.preview" alt=""/>
                    <div class="caption">
                        <h4 class="group inner list-group-item-heading">
                            {{ product.title }}</h4>
                        <p style="word-wrap: break-word; margin-bottom: 10px;" class="group inner list-group-item-text">
                            {{ product.description }}</p>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <p class="lead">
                                    ${{ product.price }}</p>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <a class="btn btn-success" @click="handleAdd(product.id)">Add to basket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="pagination.count <= products.length && !search.length" @mouseover="handleMouseover" style="width: 100%; padding: 50px;">
              <button class="more btn btn-success">More</button>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert'
import { getHeaders } from './../../../../config/env'

export default {
  name: 'products',
  data () {
    return {
      products: [],
      pagination: {
        count: 6
      },
      search: ''
    }
  },
  computed: {
    filteredProducts: function () {
      if (this.search.length) this.pagination.count = 1000000
      return this.products.filter(product => product.description.match(this.search))
    }
  },
  methods: {
    handleAdd (id) {
      this.$http.post('api/orders', { product_id: id }, { headers: getHeaders() })
        .then(() => swal('Success!', 'The product was added to your basket', 'success'))
        .catch(error => {
          if (error.status === 401) {
            this.$router.push('login')
          } else {
            console.log(error)
          }
        })
    },
    handleMouseover () {
      this.pagination.count += 6
    },
    getProducts () {
      this.$http.get('api/products')
        .then(response => {
          this.products = response.data
        })
    }
  },
  created () {
    this.getProducts()
  }
}
</script>

<style scoped>
#products-wrapper {
  text-align: center;
}

.more {
  width: 30%;
  font-size: 25px;
}

.preview {
  height: 250px;
}

.stylish-input-group .input-group-addon{
    background: white !important; 
}
.stylish-input-group .form-control{
	border-right:0; 
	box-shadow:0 0 0; 
	border-color:#ccc;
}
.stylish-input-group button{
    border:0;
    background:transparent;
}
</style>