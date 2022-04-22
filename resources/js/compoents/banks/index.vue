<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

let banks = ref([])

onMounted(async () => {
    getBanks()
})

const newBank = () => {
    router.push('/bank/add')
}

const onEdit = (id) => {
    router.push('/bank/edit/'+id)
}

const onDelete = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You can't go back",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonText: "Cancel",
        confirmButtonText: "Yes"
    })
    .then((result) => {
        if(result.value){
            axios.delete('/api/bank/'+id)
            .then((response) => {
                Swal.fire(
                    'Delete',
                    'Bank delete successfully',
                    'success'
                )
                getBanks()
            })
            .catch((error) => {
                Swal.fire(
                    'Failed',
                    'There was something wrong...',
                    'warning'
                )
            })
        }
    })
}

const getBanks = async () => {
    let response = await axios.get('/api/banks')
    banks.value = response.data.banks
}
</script>
<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link active" aria-current="page">Banks</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/calculator">Calculator</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Banks</h2>
                    </div>
                    <div class="col-sm-6">
                        <a @click="newBank" href="#" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New </span></a>

                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Interest rate</th>
                    <th>Max loan</th>
                    <th>Min down payment</th>
                    <th>Loan term</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in banks" :key="item.id" v-if="banks.length > 0">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.interest_rate }}%</td>
                    <td>{{ item.max_loan }}$</td>
                    <td>{{ item.min_loan }}%</td>
                    <td>{{ item.loan_term }} month</td>
                    <td>
                        <a href="#" class="edit" @click="onEdit(item.id)"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                        <a href="#" class="delete" @click="onDelete(item.id)"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                    </td>
                </tr>

                </tbody>
            </table>

        </div>
    </div>
</template>
