<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>

        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    hide-details
                    label="Search"
                    single-line
                ></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="resumes" :search="search">
            </v-data-table>
        </v-card>
    </v-container>
</template>
<script>
    export default {
        created() {
            this.getNewShopResumes();
        },
        data() {
            return {
                search: '',
                headers: [
                    {text: 'نام:', align: 'start', value: 'name',},
                    {text: 'نام خانوادگی:', value: 'last_name'},
                    {text: 'نام فروشگاه:', value: 'shop_name'},
                    {text: 'شماره تماس:', value: 'tel'},
                    {text: 'آدرس', value: 'address'},
                ],
                resumes: [],
            }
        },
        methods: {
            getNewShopResumes() {
                axios.post('/distributor/getAllShops')
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
