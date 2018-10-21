<template>
    <div>
        <heading class="mb-6">Cpanel Mail</heading>

        <card class="flex-col items-center justify-center" style="min-height: 200px; width:800px; margin-left:320px;">
            <div>
                <div class="flex border-b border-40">
                    <div class="w-1/5 px-6 py-6">
                        <label class="inline-block" for="email_address">
                            Email Address
                        </label>
                    </div>
                    <div class="w-1/2 px-6 py-6">
                        <input v-model="email_address" type="email" id="email_address" class="w-full form-control form-input form-input-bordered" placeholder='The username only without "@domain.com"' v-on:change="validateEmail()">
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-1/5 px-6 py-6">
                        <label class="inline-block" for="email_address">
                            Password
                        </label>
                    </div>
                    <div class="w-1/2 px-6 py-6">
                        <input v-model="password" type="password" id="password" class="w-full form-control form-input form-input-bordered">
                    </div>
                </div>
            </div>
            <div class="px-4 py-2" align="center">
                <button class="ml-auto btn btn-default btn-primary mr-3" @click="addEmail">Create</button>
            </div>
        </card>
        <br>
        <card class="flex-col items-center justify-center" style="min-height: 200px; width:800px; margin-left:320px;">
            <div align="center">
                <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        max-height="600px"
                        :lineNumbers="false"
                        :fixed-header="true"
                        styleClass="vgt-table condensed"
                        :search-options="{
                            enabled: true,
                            trigger: 'enter',
                            skipDiacritics: true,
                            searchFn: mySearchFn,
                            placeholder: 'Search this table',
                            externalQuery: searchQuery
                         }"
                        :pagination-options="{
                            enabled: true,
                            mode: 'records',
                            perPage: 10,
                            position: 'bottom',
                            perPageDropdown: [5, 10, 15,20],
                            dropdownAllowAll: true,
                            nextLabel: 'next',
                            prevLabel: 'prev',
                            rowsPerPageLabel: 'Rows per page',
                            ofLabel: 'of',
                            pageLabel: 'page', // for 'pages' mode
                            allLabel: 'All',
                            }"
                        @on-cell-click="onCellClick">
                </vue-good-table>
            </div>
        </card>
    </div>
</template>

<script>
    import { VueGoodTable } from 'vue-good-table';
    import 'vue-good-table/dist/vue-good-table.css'

export default {
    components: {
        VueGoodTable,
    },
    data() {
        return {
            email_address: "",
            password: "",
            columns: [
                {
                    label: 'Email Address',
                    field: 'email',
                },
                {
                    label: 'Quota',
                    field: 'quota'
                },
                {
                    label: 'Usage',
                    field: 'usage'
                },
                {
                    label: 'Delete',
                    field: 'delete',
                }
            ],
            rows: [],
        }
    },
    mounted() {
       this.init();
    },
    methods: {
        init(){
            Nova.request().get('/nova-vendor/cpanel-mail/')
                .then(response => {
                for (var i = 0; i < response.data.length; i++) {
                    response.data[i]['quota'] = response.data[i]['quota'] / 1024 /1024 + ' MB'
                    response.data[i]['usage'] = response.data[i]['usage'] / 1024 /1024 + ' MB'
                }
                this.rows = response.data;
        });
        },
        onCellClick(params) {
            if (params.column.label == "Delete"){
                if (confirm("Are you sure you want to delete this email address?")){
                   var email = params.row.email;
                    Nova.request().post('/nova-vendor/cpanel-mail/delete', {
                        email_address: email
                        }).then(response => {
                        if (response.data.status == 'success') {
                            this.$toasted.show(response.data.message, {type: response.data.status})
                            this.init();
                        }
                        else{
                            this.$toasted.show(response.data.message, { type: 'error' })
                        }
                    })
                    .catch(response => {
                            this.$toasted.show('Failed to delete email address!', { type: 'error' })
                    });
                }
            }
        },
        addEmail() {
            if (!this.email_address.length) {
                this.$toasted.show('Please fill the email address field', {type: 'error'})
                return false
            }
            Nova.request()
                .post('/nova-vendor/cpanel-mail/add', {
                    email_address: this.email_address,
                    password: this.password
                })
                .then(response => {
                    if (response.data.status == 'success') {
                        this.$toasted.show(response.data.message, {type: response.data.status})
                        this.init();
                    }else {
                        this.$toasted.show(response.data.message, { type: 'error' })
                    }
            })
            .catch(response => {
                this.$toasted.show('Failed to add email address!', { type: 'error' })
            });
        },
        validateEmail: function () {
            var email_field = document.getElementById("email_address");
            if (email_field.value.indexOf('@') > -1){
                email_field.value = '';
                email_field.style.border="1px solid red";
            } else{
                email_field.style.border="";
            }
        },
    },
}
</script>

<style>
    /* Scoped Styles */
</style>
