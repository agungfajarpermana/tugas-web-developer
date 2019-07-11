<template>
  <div>
    <form class="">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" :class="{'is-invalid':errors.nama}" name="nama" id="nama" placeholder="Nama Anda.." v-model="formData.nama">
            <div class="invalid-feedback" v-if="errors.nama">
              {{ errors.nama[0] }}
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="email">Email</label>
            <input type="text" class="form-control" :class="{'is-invalid':errors.email}" name="email" id="email" placeholder="Email Anda.." v-model="formData.email">
            <div class="invalid-feedback" v-if="errors.email">
              {{ errors.email[0] }}
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="telpon">Telepon</label>
            <input type="text" class="form-control" :class="{'is-invalid':errors.no_telp}" name="no_telp" id="telpon" placeholder="Telepon Anda.." v-model="formData.no_telp">
            <div class="invalid-feedback" v-if="errors.no_telp">
              {{ errors.no_telp[0] }}
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="pesan">Pesan</label>
            <textarea class="form-control" :class="{'is-invalid':errors.pesan}" name="pesan" id="pesan" cols="30" rows="3" placeholder="pesan anda.." v-model="formData.pesan"></textarea>
            <div class="invalid-feedback" v-if="errors.pesan">
              {{ errors.pesan[0] }}
            </div>
          </div>
          <div class="form-group col-md-6">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" :class="{'is-invalid':errors.alamat}" name="alamat" id="alamat" cols="30" rows="3" placeholder="alamat anda.." v-model="formData.alamat"></textarea>
            <div class="invalid-feedback" v-if="errors.alamat">
              {{ errors.alamat[0] }}
            </div>
          </div>
        </div>
        <button type="submit" class="btn" :class="color" v-bind:disabled="!before" @click.prevent="active ? updateData(formData.id) : saveData()">
          <span class="spinner-grow spinner-grow-sm" v-if="!before" role="status" aria-hidden="true"></span>
          {{ text }}
        </button>
      </form>
  </div>
</template>

<script>
  import Swal from 'sweetalert2/dist/sweetalert2.js';
  import 'sweetalert2/src/sweetalert2.scss';

  export default {
    props: ['active','text','color'],
    data(){
      return {
        formData: {
          nama: '',
          email: '',
          no_telp: '',
          pesan: '',
          alamat: ''
        },
        before: true,
        errors: {}
      }
    },
    methods: {
      saveData(){ 
        this.beforeSend()

        axios.post('/biodata/create', this.$data.formData)
          .then((res) => {

            if(res.data.status == true){
              this.$parent.ListData.push(res.data.data)
              this.$parent.ListData.sort((first,second) => {
                if(first.nama > second.nama) return 1;
                else return -1;
              });
              this.$data.formData = this.$data.errors = ''
              this.customTextLoad();

              Swal.fire({
                title: 'Good Job!',
                text: res.data.msg,
                type: 'success',
                confirmButtonText: 'Ah Siap!'
              });

              return false;
            }

            Swal.fire({
              title: 'Oops!',
              text: res.data.msg,
              type: 'error',
              confirmButtonText: 'Mengerti!'
            });
            this.customTextLoad()
          })
          .catch((err) => {
            this.errors = err.response.data.errors;
            this.customTextLoad()
          });
      },

      updateData(id){
        this.beforeSend()

        axios.put(`/biodata/update/${id}`, this.$data.formData)
          .then((res) => {

            if(res.data.status == true){
              this.$data.formData = res.data.data;
              this.$data.formData = this.$data.errors = '';
              this.$emit('changeTextBtn');
              this.customTextLoad()

              Swal.fire({
                title: 'Good Job!',
                text: res.data.msg,
                type: 'success',
                confirmButtonText: 'Ah Siap!'
              });

              return false;
            }

            Swal.fire({
              title: 'Oops!',
              text: res.data.msg,
              type: 'error',
              confirmButtonText: 'Mengerti!'
            });
            this.customTextLoad()
          }).catch((err) => {
            this.errors = err.response.data.errors;
            this.customTextLoad()
          })
      },

      beforeSend(){
        this.before = false
        this.$parent.text2 = 'Loading..'
      },

      customTextLoad(){
        this.$data.before = true
        this.$parent.text2 = 'Simpan Data'
      }
    }
  }
</script>
