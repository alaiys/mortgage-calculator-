<script setup>
import { ref } from "vue"
import { useRouter } from 'vue-router'

const router = useRouter()

let form = ref({
    name:'',
    interest_rate:'',
    max_loan:'',
    min_loan:'',
    loan_term:''
})

let errors = ref({
    name_already_exist:'',
    min_loan_big:'',
    max_loan:'',
    min_loan:'',
    loan_term:''
})

const saveBank = () => {
    const formData = new FormData()
    formData.append('name', form.value.name)
    formData.append('interest_rate', form.value.interest_rate)
    formData.append('max_loan', form.value.max_loan)
    formData.append('min_loan', form.value.min_loan)
    formData.append('loan_term', form.value.loan_term)

    axios.post('/api/bank/', formData)
     .then((response) => {
         form.value.name=''
         form.value.interest_rate=''
         form.value.max_loan=''
         form.value.min_loan=''
         form.value.loan_term=''

         router.push('/')

         toast.fire({
             icon:'success',
             title:'Bank add successfully'
         })

     })
     .catch((error) => {

     })
}
</script>
<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Banks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/calculator">Calculator</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card shadow">
                    <div class="card-title text-center border-bottom">
                        <h2 class="p-3">Add bank</h2>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="saveBank()">
                            <div class="mb-4">
                                <label class="form-label">Name</label>
                                <input v-model="form.name" type="text" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Interest rate %</label>
                                <input v-model="form.interest_rate" type="number" class="form-control" max="90" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Maximum loan</label>
                                <input v-model="form.max_loan" type="number" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Minimum down payment %</label>
                                <input v-model="form.min_loan" type="number" max="90" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Loan term (month)</label>
                                <input v-model="form.loan_term" type="number" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
