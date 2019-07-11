<template>
  <div class="row">
    <div class="col-md-5">
      <h5 class="text-center">Form Calon Karyawan</h5>

      <hr>

      <Form 
        :active="active" 
        :text="text2" 
        :color="color" 
        @changeTextBtn="changeText" />

    </div>
    
    <div class="col-md-7">
      <h5 class="text-center mb-3">Data Calon Karyawan</h5>

      <table class="table table-striped table-responsive{-md}" width="100%">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Telepon</th>
            <th scope="col">Email</th>
            <th scope="col">Alamat</th>
            <th scope="col">Pesan</th>
            <th scope="col" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="load">
            <td colspan="7" class="text-center">
              <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
            </td>
          </tr>

          <tr v-for="(list,key) in ListData" :key="list.id">
            <th scope="row">{{ (key+1) }}</th>
            <td>{{ list.nama }}</td>
            <td>{{ list.no_telp }}</td>
            <td>{{ list.email }}</td>
            <td>{{ list.alamat }}</td>
            <td>{{ list.pesan }}</td>
            <td class="text-center">
              <a href="#" class="btn btn-sm" :class="color" @click="active == false ? editDataBio(key) : cancelEdit(key)">{{ text1 }}</a>
              <a href="#" class="btn btn-sm btn-danger" @click="deleteData(key,list.id)">Delete</a>
            </td>
          </tr>

          <tr>
            <td v-if="ListData.length == 0" colspan="7" class="text-center">Data Belum Tersedia</td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
</template>

<script>
  import Swal from 'sweetalert2/dist/sweetalert2.js';
  import 'sweetalert2/src/sweetalert2.scss';
  import Form from './Form.vue';

  export default {
    data(){
      return {
        ListData: {},
        text1: 'Edit',
        text2: 'Simpan Data',
        color: 'btn-warning',
        active: false,
        load: true
      }
    },
    components: {
      Form
    },
    mounted(){

      this.getDataBio()

    },
    methods: {

      getDataBio(){
        axios.get('/biodata/')
          .then((res) => {
            this.ListData = res.data
            this.load = false
          }).catch((err) => {
            console.log(err)
            Swal.fire({
              title: 'Oops!',
              text: 'Laporkan Admin!',
              type: 'error',
              confirmButtonText: 'Mengerti!'
            });
          });
      },

      editDataBio(key){
        this.$children[0].formData = this.ListData[key]
        this.customText()
      },

      cancelEdit(key){
        this.$children[0].formData = ''
        this.customCancelText()
      },

      changeText(){
        this.customCancelText()
      },

      deleteData(key,id){
        Swal.fire({
          title: 'Anda yakin?',
          text: "Ingin menghapus data ini!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus aja!',
          cancelButtonText: 'Jangan sekarang!'
        }).then((result) => {
          if (result.value) {
            this.$children[0].errors = ''
            this.customLoading()

            axios.delete(`/biodata/delete/${id}`)
              .then((res) => {
                if(res.data.status == true){
                  this.ListData.splice(key,1)

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
              }).catch((err) => {
                console.log(err)
                Swal.fire({
                  title: 'Oops!',
                  text: 'Laporkan Admin!',
                  type: 'error',
                  confirmButtonText: 'Mengerti!'
                });
              });
          }
        })
      },

      customText(){
        this.active = true
        this.text1 = 'Batal'
        this.text2 = 'Edit Data'
        this.color = 'btn-info'
        this.$children[0].errors = ''
      },

      customCancelText(){
        this.active = false
        this.text1 = 'Edit'
        this.text2 = 'Simpan Data'
        this.color = 'btn-warning'
      },

      customLoading(){
        Swal.fire({
            title: 'Loading!',
            html: 'Mohon bersabar.',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        });
      }

    }
  }
</script>


<style scope>
  .table{
    overflow-y: hidden;
  }
</style>
