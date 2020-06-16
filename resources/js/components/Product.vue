<template>
    <div class="container">
        <div class="row justify-content-center">


          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product List</h3>
                <div class="card-tools ">
                    <div class="input-group input-group-sm">
                  <button class="btn btn-success" @click="newModel">Add <i class="fas fa-plus"></i></button>
                    </div>
                </div>



              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title Product</th>
                      <th>Brand</th>
                      <th>Category</th>
                      <th>Subcategory</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="product in products" :key="product.id">
                      <td>{{ product.id }}</td>
                      <td>{{ product.title | upText }}</td>
                      <td>{{ product.brand | upTextAll }}</td>
                      <td>{{ (product.category.parent_id == null) ? product.category.name : product.category.parent.name   }}</td>

                      <td>
                        {{ (product.category.parent_id !== null) ? product.category.name : 'N/A'  }}
                      </td>

                      <td>
                          <a href="#" @click="editModel(product)">
                              <i class="fa fa-edit text-blue"></i>
                          </a>
                            /
                          <a href="#" @click="deleteData(product.id)">
                              <i class="fa fa-trash text-red"></i>
                          </a>
                      </td>                      
                    </tr>


                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <!-- Modal -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editmode" class="modal-title" id="addModalLabel">Add New Product</h5>
        <h5 v-show="editmode" class="modal-title" id="addModalLabel">Update Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form @submit.prevent="editmode ? updateData() : createData() ">
      <div class="modal-body">

        <div class="form-group">
          <label>Title Product</label>
          <input v-model="form.title" type="text" name="title"
            placeholder="Enter title"
            class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
          <has-error :form="form" field="title"></has-error>
        </div>

        <div class="form-group">
          <label>Brand</label>
          <input v-model="form.brand" type="text" name="brand"
            placeholder="Enter brand"
            class="form-control" :class="{ 'is-invalid': form.errors.has('brand') }">
          <has-error :form="form" field="brand"></has-error>
        </div>

        <div class="form-group">
          <label>Category</label>
          <select name="category_id" id="category" class="form-control"
                v-model="form.category_id"
                :class="{ 'is-invalid': form.errors.has('category') }"               
                >
            <option value="">Select Category</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>

          </select>
          <has-error :form="form" field="category"></has-error>
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea v-model="form.description" type="text" name="description"
            placeholder="Short your description"
            class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
          <has-error :form="form" field="description"></has-error>
        </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
      </div>
      </form>

    </div>
  </div>
</div>
        

        </div>
    </div>
    
</template>

<script>
    export default {
        data() {
            return {
                // register
                form: new Form({
                    // parameter unit
                    id: '',
                    title : '',
                    brand : '',
                    category_id: '',
                    // subcategory : '',
                    description : ''
                }),
                products : {},
                categories : {},
                editmode: false
            }
        },
        methods: {
          createData() {
            this.$Progress.start()               
            this.form.post('api/products')
            .then( () =>{
                
                Fire.$emit('AfterCreate')
                $('#addNew').modal('hide')
                Toast.fire({
                  icon: 'success',
                  title: 'Data created in successfully'
                })            
                this.$Progress.finish()
            })
            .catch( ()=>{
              // Calling error
              this.$Progress.fail()  
            })

          },
          loadData(){
            axios.get('api/products').then( ({ data }) => (this.products = data.products.data) );
            axios.get('api/categories').then( ({ data }) => (this.categories = data.categories.data) );
          },
          deleteData(id) {
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

              // send requet to the server
              if (result.value) {              
                  this.form.delete('api/products/'+id)
                  .then( ()=> {
                      Fire.$emit('AfterCreate')
                      Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )               
                  })
                  .catch( ()=>{
                      Swal.fire(
                        'Failed!',
                        'There was something wrong.',
                        'warning'
                      )               
                  })

              }
            })
          },
          newModel() {
            this.editmode = false
            this.form.reset()
            $('#addNew').modal('show')
          },
          editModel(user) {
            this.editmode = true
            this.form.reset()
            // this.form.clear ()
            $('#addNew').modal('show')
            this.form.fill(user)
          },
          updateData() {
            //console.log('Editing data')
            this.$Progress.start()  
            this.form.put('api/products/'+this.form.id)
            .then( ()=> {
                // success
                $('#addNew').modal('hide')               
                Swal.fire(
                'Updated!',
                'Your Information has been updated.',
                'success'
                )  
                Fire.$emit('AfterCreate')              
                this.$Progress.finish()
            })
            .catch( ()=>{
                this.$Progress.fail()  
            })
          }   

        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {           
            this.loadData();

            Fire.$on('AfterCreate', () => {
              this.loadData()
            })
        }
    }
</script>