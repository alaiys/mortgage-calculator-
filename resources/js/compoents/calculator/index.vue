<script setup>
import { useRouter } from 'vue-router'
import {onMounted, ref} from "vue";
const router = useRouter()

let banks = ref([])

let selectedBank = ref([])

let calculator = ref({
    initial_loan:0,
    initial_loan_error:'',
    down_payment:0,
    down_payment_percent:0,
    down_payment_error:'',
    bank_id:0,
    monthly_payment:0,
})

onMounted(async () => {
    getBanks()
})

const getBanks = async () => {
    let response = await axios.get('/api/banks')
    banks.value = response.data.banks
}

const getBank = async (id) => {
    let response = await axios.get("/api/bank/"+id)
    selectedBank.value = response.data.bank
}

const calculate = () => {
    calculator.value.initial_loan_error = '';
    calculator.value.down_payment_error = '';
    calculator.value.monthly_payment = 0;

    if(selectedBank.value.max_loan < calculator.value.initial_loan) {
        calculator.value.initial_loan_error = 'Initial loan bigger then max loan in this bank!'
    }
    if(selectedBank.value.min_loan > ((calculator.value.down_payment*100/calculator.value.initial_loan))) {
        calculator.value.down_payment_error = 'Down payment less then min loan in this bank!'
    }
    if(calculator.value.initial_loan > 0) {
        calculator.value.monthly_payment =
            Math.round(( (calculator.value.initial_loan-calculator.value.down_payment) * (selectedBank.value.interest_rate/100/12) * Math.pow((1+(selectedBank.value.interest_rate/100/12)),selectedBank.value.loan_term) ) / (Math.pow((1+(selectedBank.value.interest_rate/100/12)),selectedBank.value.loan_term) - 1) )
    }
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
                        <span class="nav-link active" aria-current="page">Calculator</span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="calculator">
        <div class="d-flex justify-content-center">
            <div class="row w-25">
                <h3 class="d-flex justify-content-center align-items-center mb-3 mt-3">Mortgage calculator</h3>
                <div class="border">

                    <label class="form-label mt-3">Initial Loan</label>
                    <div class="input-group mb-3">
                        <input v-model="calculator.initial_loan" type="number" class="form-control" required>
                        <span class="input-group-text" id="basic-addon1">$</span>
                    </div>
                    <div class="alert alert-danger" role="alert" v-if="calculator.initial_loan_error.length > 0">
                        {{calculator.initial_loan_error}}
                    </div>

                    <label class="form-label">Down Payment (amount)</label>
                    <div class="input-group mb-3">

                        <input class="form-control" v-model="calculator.down_payment" type="number">
                        <span class="input-group-text" id="basic-addon2">$</span>
<!--                        <input class="form-control" v-model="calculator.down_payment_percent" max="90" type="number">
                        <span class="input-group-text">%</span>-->
                    </div>

                    <div class="alert alert-danger" role="alert" v-if="calculator.down_payment_error.length > 0">
                        {{calculator.down_payment_error}}
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bank</label>
                        <select @change="getBank(calculator.bank_id)" v-model="calculator.bank_id" class="form-select" aria-label="Banks">
                            <option selected value="0" disabled>Select</option>
                            <option v-for="item in banks" :value="item.id">{{ item.name }}</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-center mb-3" v-if="calculator.initial_loan > 0 && calculator.down_payment > 0 && calculator.bank_id > 0">
                        <button @click="calculate()" type="button" class="btn btn-primary">Calculate</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="d-flex justify-content-center" v-if="calculator.down_payment_error.length == 0 && calculator.initial_loan_error.length == 0 && calculator.monthly_payment > 0">
            <div class="row w-25">
                <h3 class="d-flex justify-content-center align-items-center mb-3 mt-3">Results</h3>
                <div class="border">
                    <h2 class="mb-3 mt-3">
                        {{calculator.monthly_payment}}$ per month
                    </h2>
                </div>

            </div>
        </div>
    </div>
</template>
