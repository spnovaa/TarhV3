<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>

        <v-card>
            <v-card-title>
                <v-text-field v-model="search" append-icon="mdi-magnify" hide-details label="Search"
                              single-line></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="resumes" :search="search">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn :to="{ path: '/shopShow/'+ item.id}" color="primary" dark fab title="ورود" x-small>
                        <v-icon small>mdi-eye</v-icon>
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>
<script>
    export default {
        created() {
            this.getAllShops();
        },
        data() {
            return {
                search: '',
                headers: [
                    {text: 'نام فروشگاه:', value: 'shop_name'},
                    {text: 'شماره تماس:', value: 'tel'},
                    {text: 'آدرس', value: 'address'},
                    {text: 'پیشخوان:', value: 'actions', sortable: false},
                ],
                resumes: [],
            }
        },
        methods: {
            getAllShops() {
                axios.post('/getAllShops')
                    .then((data) => {
                        if (data.data) {
                            this.resumes = data.data;
                        }
                    })
                    .catch(() => {
                        this.logout();
                    });
            },

        }
    }
</script>
